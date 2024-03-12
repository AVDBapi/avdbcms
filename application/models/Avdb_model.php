<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
#[AllowDynamicProperties]
class Avdb_model extends CI_Model
{
    protected string $api = "https://avdbapi.com/api.php/provide/vod";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set(ovoo_config('timezone'));
    }

    function get_movies_page($page = 1, $param)
    {
        $data = file_get_contents($this->api . "/?ac=list&pg=".$page.$param);
        $data = json_decode($data, true);

        $response = array();
        $movies = array();
        if (empty($data) || $data['code'] != 1) {
            $response['status'] = 'fail';
        } else {
            $response['status'] = 'success';
            foreach ($data['list'] as $movie) {
                array_push($movies, ['id' => $movie['id'], 'code' => $movie['movie_code']]);
            }
            $response['movies'] = $movies;
        }

        return $response;
    }

    function get_movies_today()
    {
        $data = file_get_contents($this->api . "/?ac=list&h=24");
        $data = json_decode($data, true);

        $response = array();
        if (empty($data) || $data['code'] != 1) {
            $response['status'] = 'fail';
        } else {
            $response['status'] = 'success';
            $pages = [];
            $count = (int) $data['pagecount'];
            for ($i = 1; $i <= $count; $i++) {
                array_push($pages, $i);
            }
            $response['pages'] = $pages;
        }

        return $response;
    }

    function get_movies_all()
    {
        $data = file_get_contents($this->api . "/?ac=list");
        $data = json_decode($data, true);

        $response = array();
        if (empty($data) || $data['code'] != 1) {
            $response['status'] = 'fail';
        } else {
            $response['status'] = 'success';
            $pages = [];
            $count = (int) $data['pagecount'];
            for ($i = 1; $i <= $count; $i++) {
                array_push($pages, $i);
            }
            $response['pages'] = $pages;
        }

        return $response;
    }

    function get_movie_by_id($id)
    {
        $data = file_get_contents($this->api . "/?ac=detail&ids=" . $id);
        $data = json_decode($data, true);
        $response = array();
        if (empty($data) || $data['code'] != 1) {
            $response['status'] = 'fail';
        } else {
            $movie_data = $data['list'][0];
            $msg = $this->insert_or_update_movie($movie_data);
            $response['status'] = 'success';
            $response['msg'] = $msg;
        }

        return $response;
    }

    function insert_or_update_movie($data)
    {
        if (empty($data)) {
            $response = "Data error";
        }

        $isExist = $this->common_model->tmdb_exist($data['id']);

        if ($isExist) { // Update
            $videos_id = $this->db->get_where('videos', array('tmdbid' => $data['id']))->row()->videos_id;
            $this->db->where('videos_id', $videos_id);
            $this->db->delete('video_file');

            $episodes = $data['episodes']['server_data'];
            $this->insert_episode($videos_id, $episodes);
            $response = 'ID: '.$data['id'].' CODE: '.$data['movie_code'] . ' => Updated';
        } else { // Insert
            $this->update_actors($data['actor']);
            $this->update_directors($data['director']);
            $genres = implode(',', $data['category']);

            $movie_data['tmdbid'] = $data['id'];
            $movie_data['title'] = $data['name'];
            $movie_data['seo_title'] = $data['slug'];
            $movie_data['slug'] = $data['slug'];
            $movie_data['description'] = $data['description'];
            $movie_data['runtime'] = $data['time'];
            $movie_data['stars'] = implode(',', $data['actor']);
            $movie_data['director'] = implode(',', $data['director']);
            $movie_data['writer'] = 'updating';
            $movie_data['country'] = implode(',', $data['country']);
            $movie_data['genre'] = $this->genre_model->get_genre_ids($genres);
            $movie_data['imdb_rating'] = 'n/a';
            $movie_data['release'] = $data['year'];
            $movie_data['video_quality'] = 'HD';
            $movie_data['publication'] = '1';
            $movie_data['enable_download'] = '0';
            $movie_data['trailler_youtube_source'] = '';
            $this->db->insert('videos', $movie_data);
            $insert_id = $this->db->insert_id();

            // Update slug
            $slug = url_title($data['name'], 'dash', TRUE);
            $slug_num = $this->common_model->slug_num('videos', $slug);
            if ($slug_num > 0) {
                $slug = $slug . '-' . $insert_id;
            }
            $this->db->where('videos_id', $insert_id);
            $this->db->update('videos', ['slug' => $slug]);

            // save thumbnail
            $image_source = $data['thumb_url'];
            $save_to = 'uploads/video_thumb/' . $insert_id . '.jpg';
            $this->common_model->grab_image($image_source, $save_to);
            // save poster
            $image_source = $data['poster_url'];
            $save_to = 'uploads/poster_image/' . $insert_id . '.jpg';
            $this->common_model->grab_image($image_source, $save_to);

            // Episodes
            $episodes = $data['episodes']['server_data'];
            $this->insert_episode($insert_id, $episodes);

            $response = 'ID: '.$data['id'].' CODE: '.$data['movie_code'] . ' => Inserted';
        }

        return $response;
    }

    function insert_episode($video_id, $episodes)
    {
        $file_data = array();

        if (count($episodes) > 1) {
            $this->db->where('videos_id', $video_id);
            $this->db->update('videos', ['is_tvseries' => '1']);
        }

        foreach ($episodes as $ep) {
            $file_data['videos_id'] = (int) $video_id;
            $file_data['file_source'] = 'embed';
            $file_data['stream_key'] = 'avdbcms';
            $file_data['source_type'] = 'link';
            $file_data['file_url'] = $ep['link_m3u8'];
            $file_data['label'] = $ep['slug'];

            $this->db->insert('video_file', $file_data);
        }
    }

    function update_actors($actors)
    {
        foreach ($actors as $actor) {
            $this->common_model->get_star_id_by_name('actor', $actor);
        }
    }
    function update_directors($directors)
    {
        foreach ($directors as $director) {
            $this->common_model->get_star_id_by_name('director', $director);
        }
    }
}