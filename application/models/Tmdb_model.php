<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#[AllowDynamicProperties]
class Tmdb_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set(ovoo_config('timezone'));
        require_once APPPATH . "third_party/tmdb/tmdb-api.php";
        $this->tmbd_api_key   = ovoo_config('tmbd_api_key');
        $this->tmdb           = new TMDB(); 
        $this->tmdb->setAPIKey($this->tmbd_api_key);
    }    
    function get_movie_info($tmdb_id='', $lang ='en')
    {
      $this->tmdb->setLang($lang);
      $purchase_code  = trim($this->db->get_where('config' , array('title'=>'purchase_code'))->row()->value ?? "");
      if($purchase_code =='' || $purchase_code==NULL):
        $purchase_code  = '123456987123';
      endif;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '550';
      endif;
      $movie          = $this->tmdb->getMovie($tmdb_id);
      $data           = $movie ->getJSON();
      $data           = json_decode($data, true);
      if(empty($data)){
        $response['status']    = 'fail';
      }else{
        $actors         = array();
        $directors      = array();
        $writters       = array();
        $countries      = array();
        $genres         = array(); 
        if(count($data) >0){
          $a          = $this->update_actors($data['credits']['cast']);
          $dw         = $this->update_directors_writers($data['credits']['crew']);

    	  	$actors        = $this->filter_actors($data['credits']['cast']);
    	  	$directors     = $this->filter_directors($data['credits']['crew']);
    	  	$writters      = $this->filter_writters($data['credits']['crew']);
    	  	$countries     = $this->filter_countries($data['production_countries']);
    	  	$genres        = $this->filter_genres($data['genres']);
        }
    		$response      = array();
    		if(count($data) >0 && $data['title'] !='' && $data['title'] !=NULL){
          $response['status']         = 'success';
          $response['imdbid']         = $data['imdb_id'];//$data['imdbID'];
          $response['title']          = $data['title'];
          $response['plot']           = $data['overview'];
          $response['runtime']        = $data['runtime'].' Min';
          $response['actor']          = $actors;//$this->common_model->get_star_ids('actor',$data['Actors']);
          $response['director']       = $directors;//$this->common_model->get_star_ids('director',$data['Director']);
          $response['writer']         = $writters;//$this->common_model->get_star_ids('writer',$data['Writer']);
          $response['country']        = $countries;//$this->common_model->get_country_ids($data['Country']);
          $response['genre']          = $genres;//$this->common_model->get_genre_ids($movie->getGenres());
          $response['rating']         = $data['vote_average'];
          $response['release']        = $data['release_date'];
          $response['thumbnail']      = 'https://image.tmdb.org/t/p/w300/'.$data['poster_path'];
          $response['poster']         = 'https://image.tmdb.org/t/p/w1280/'.$data['backdrop_path'];
          $response['trailler_youtube_source']         = 'https://www.youtube.com/watch?v='.$this->extract_trailer_youtube_source($data['trailers']['youtube']);
        }else{
          $response['status']    = 'fail';
        }
      }
  	return $response;    
  }

  function get_tvseries_info($tmdb_id='', $lang ='en')
    {
      $this->tmdb->setLang($lang);
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      $tvshow           = $this->tmdb->getTVShow($tmdb_id);
      $data             = $tvshow ->getJSON();
      $data             = json_decode($data, true);
      if(empty($data)){
        $response['status']    = 'fail';
      }else{
        $actors         = array();
        $directors      = array();
        $writters       = array();
        $countries      = array();
        $genres         = array();
        if(count($data) >0){
          $a          = $this->update_actors($data['credits']['cast']);
          $dw         = $this->update_directors_writers($data['credits']['crew']);

          $actors       = $this->filter_actors($data['credits']['cast']);
          $directors    = $this->filter_directors($data['credits']['crew']);
          $writters     = $this->filter_writters($data['credits']['crew']);
          $countries    = $this->filter_tv_countries($data['origin_country']);
          $genres       = $this->filter_genres($data['genres']);
        }
        $response       = array();
        if(count($data) >0 && $data['original_name'] !='' && $data['original_name'] !=NULL){
          $response['status']         = 'success';
          $response['imdbid']         = '';//$data['imdb_id'];//$data['imdbID'];
          $response['title']          = $data['original_name'];
          $response['plot']           = $data['overview'];
          $response['runtime']        = '';///$data['episode_run_time'].' Min';
          $response['actor']          = $actors;//$this->common_model->get_star_ids('actor',$data['Actors']);
          $response['director']       = $directors;//$this->common_model->get_star_ids('director',$data['Director']);
          $response['writer']         = $writters;//$this->common_model->get_star_ids('writer',$data['Writer']);
          $response['country']        = $countries;//$this->common_model->get_country_ids($data['Country']);
          $response['genre']          = $genres;//$this->common_model->get_genre_ids($movie->getGenres());
          $response['rating']         = $data['vote_average'];
          $response['release']        = $data['first_air_date'];
          $response['thumbnail']      = 'https://image.tmdb.org/t/p/w300/'.$data['poster_path'];
          $response['poster']         = 'https://image.tmdb.org/t/p/w1280/'.$data['backdrop_path'];
          $response['trailler_youtube_source']         = '';
        }else{
          $response['status']    = 'fail';
        }
      }
    return $response;
    
  }


  function get_movie_actor_info($tmdb_id='')
    {
      $added_star     = 0;
      $purchase_code  = trim($this->db->get_where('config' , array('title'=>'purchase_code'))->row()->value ?? "");
      if($purchase_code =='' || $purchase_code==NULL):
        $purchase_code  = '123456987123';
      endif;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      //$data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/xxxxxxxxxx/'.$tmdb_id);
      $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_movie_json/'.$purchase_code.'/'.$tmdb_id);
      $data           = json_decode($data, true);
      if(isset($data['error_message'])){
        $response['status']    = 'fail';
      }else{
        //var_dump($data);
        $actors         = array();
        $directors      = array();
        $writters       = array();        
        if(count($data) >0){
          $actors       = $this->update_actors($data['credits']['cast']);
          $stars        = $this->update_directors_writers($data['credits']['crew']);
          $added_star   = $actors + $stars;
        }
      }
      return $added_star;    
  }

  function get_tvshow_actor_info($tmdb_id='')
    {
      $added_star     = 0;
      $purchase_code  = trim($this->db->get_where('config' , array('title'=>'purchase_code'))->row()->value ?? "");
      if($purchase_code =='' || $purchase_code==NULL):
        $purchase_code  = '123456987123';
      endif;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      $data           = file_get_contents('http://ovoo.spagreen.net/scrapper/v20/get_tvshow_json/'.$purchase_code.'/'.$tmdb_id);
      $data           = json_decode($data, true);
      if(isset($data['error_message'])){
        $response['status']    = 'fail';
      }else{
        //var_dump($data);
        $actors         = array();
        $directors      = array();
        $writters       = array();        
        if(count($data) >0){
          $actors       = $this->update_actors($data['credits']['cast']);
          $stars        = $this->update_directors_writers($data['credits']['crew']);
          $added_star   = $actors + $stars;
        }
      }
      return $added_star;    
  }


  function update_actors($actors){
    $added_star =0;
    for ($i=0; $i<sizeof($actors); $i++) {     
      $actors_name        = trim($actors[$i]['name'] ?? "");
      $org_profile_path   = trim($actors[$i]['profile_path'] ?? "");
      $profile_path       = 'https://image.tmdb.org/t/p/w185'.$org_profile_path;
      $num_rows           = $this->db->get_where('star', array('star_name'=>$actors_name))->num_rows();
      if($num_rows==0):
        $added_star++;
        $data['star_type']  = 'actor';
        $data['star_name']  = $actors_name;
        $data['slug']       = $this->common_model->get_seo_url($actors_name);
        $this->db->insert('star',$data);
        $insert_id = $this->db->insert_id();
        if($org_profile_path !='' && $org_profile_path !=NULL && $org_profile_path !='null'):
            $save_to = 'uploads/star_image/'.$insert_id.'.jpg';
            if(ovoo_config("tmdb_image_import_by_cron") == "1"):
              $cron_data['type']       = "image";
              $cron_data['action']     = "download";
              $cron_data['image_url']  = $profile_path;
              $cron_data['save_to']    = $save_to;
              $this->db->insert('cron',$cron_data);
            else:
                  $this->common_model->grab_image($profile_path,$save_to);
                    //var_dump($this->db->last_query()); exit;
            endif;
        endif;
      endif;
    }
    return $added_star;
  }
  function update_directors_writers($stars){
    $added_star =0;
    for ($i=0; $i<sizeof($stars); $i++) {      
      $actors_name        = trim($stars[$i]['name'] ?? "");
      $org_profile_path   = trim($stars[$i]['profile_path'] ?? "");
      $profile_path       = 'https://image.tmdb.org/t/p/w138_and_h175_bestv2'.$org_profile_path;
      $num_rows           = $this->db->get_where('star', array('star_name'=>$actors_name))->num_rows();
      if($num_rows==0):
        $added_star++;
        if($stars[$i]['department'] =='Directing' && $stars[$i]['job'] =='Director'){
          $data['star_type']  ='director';
        }else if($stars[$i]['department'] =='Writing'){
          $data['star_type']  ='writer';
        }else{
          $data['star_type']  ='actor';
        }
        $data['star_name']  = $actors_name;
        $data['slug']       = $this->common_model->get_seo_url($actors_name);
        $this->db->insert('star',$data);
        $insert_id = $this->db->insert_id();
        if($org_profile_path !='' && $org_profile_path !=NULL && $org_profile_path !='null'):
            $save_to = 'uploads/star_image/'.$insert_id.'.jpg';
            if(ovoo_config("tmdb_image_import_by_cron") == "1"):
                $cron_data['type']       = "image";
                $cron_data['action']     = "download";
                $cron_data['image_url']  = $profile_path;
                $cron_data['save_to']    = $save_to;
                $this->db->insert('cron',$cron_data);
            else:
                $this->common_model->grab_image($profile_path,$save_to);
            endif;
        endif;
      endif;
    }
    return $added_star;
  }




    
	//echo $movie->getJSON();
  function filter_actors($actors){
    $actors_name = '';
    for ($i=0; $i<sizeof($actors); $i++) {
      if($i>0){
         $actors_name .=',';
      }
      $actors_name .= trim($actors[$i]['name'] ?? "");
    }
    return $actors_name;
  }

  function filter_directors($directors){
    $j=0;
    $directors_name = '';
    for ($i=0; $i<sizeof($directors); $i++) {        
      if($directors[$i]['department'] =='Directing' && $directors[$i]['job'] =='Director'){
        if($j>0){
           $directors_name .=',';
        }
        $j++;
        $directors_name .= trim($directors[$i]['name'] ?? "");
      }
    }
    return $directors_name;
  }
  function filter_writters($writters){
    $writter_name = '';
    $j=0;
    for ($i=0; $i<sizeof($writters); $i++) {        
      if($writters[$i]['department'] =='Writing'){
        if($j>0){
           $writter_name .=',';
        }
        $j++;
        $writter_name .= trim($writters[$i]['name'] ?? "");
      }
    }
    return $writter_name;
  }

  function filter_genres($genres){
    $genres_name = '';
    for ($i=0; $i<sizeof($genres); $i++) {
      if($i>0){
         $genres_name .=',';
      }
      $genres_name .= trim($genres[$i]['name'] ?? "");
    }
    return $genres_name;
  }

  function filter_countries($countries){
    $countries_name = '';
    for ($i=0; $i<sizeof($countries); $i++) {
      if($i>0){
         $countries_name .=',';
      }
      $countries_name .= trim($countries[$i]['name'] ?? "");
    }
    return $countries_name;
  }

  function filter_tv_countries($countries){
    $countries_name = '';
    for ($i=0; $i<sizeof($countries); $i++) {
      if($i>0){
         $countries_name .=',';
      }
      $countries_name .= trim($countries[$i] ?? "");
    }
    return $countries_name;
  }


  function search($title='',$to=''){
      $data = array();
      $purchase_code  = trim($this->db->get_where('config' , array('title'=>'purchase_code'))->row()->value ?? "");
      if($purchase_code =='' || $purchase_code==NULL):
        $purchase_code  = '123456987123';
      endif;
      if($title =='' || $title==NULL):
        $title  = '00000000';
      endif;
      if($to =='tv'):
        $tvshows          = $this->tmdb->searchTVShow($title);
        foreach ($tvshows as $tvshow):
            $data[] = $tvshow->getJSON();
        endforeach;
      else:
        $movies          = $this->tmdb->searchMovie($title);
        foreach ($movies as $movie):
            $data[] = $movie->getJSON();
        endforeach;        
      endif;
      if(empty($data)):
        $data['error_message']    = 'Not found';
      endif;
    return $data;
  }

  function import_movie_info($tmdb_id=''){
      $tmdb_language      =   $this->db->get_where('config' , array('title'=>'tmdb_language'))->row()->value;
      $this->tmdb->setLang($tmdb_language);
      $response      = TRUE;
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      $movie          = $this->tmdb->getMovie($tmdb_id);
      $data           = $movie ->getJSON();
      $data           = json_decode($data, true);
      if(empty($data)){
        $response      = FALSE;
      }else{
        $actors         = array();
        $directors      = array();
        $writters       = array();
        $countries      = array();
        $genres         = array();
        if(count($data) >0){
          $a          = $this->update_actors($data['credits']['cast']);
          $dw         = $this->update_directors_writers($data['credits']['crew']);
          
          $actors        = $this->filter_actors($data['credits']['cast']);
          $directors     = $this->filter_directors($data['credits']['crew']);
          $writters      = $this->filter_writters($data['credits']['crew']);
          $countries     = $this->filter_countries($data['production_countries']);
          $genres        = $this->filter_genres($data['genres']);
        }
        if(count($data) >0 && $data['title'] !='' && $data['title'] !=NULL){
          //$actors       = $this->update_actors($data['credits']['cast']);
          //$stars        = $this->update_directors_writers($data['credits']['crew']);
          //$this->get_movie_actor_info($tmdb_id);
          $movie_data['imdbid']         = $data['imdb_id'];//$data['imdbID'];
          $movie_data['tmdbid']         = $tmdb_id;//$data['imdbID'];
          $movie_data['title']          = $data['title'];
          $movie_data['seo_title']      = $data['title'];
          $movie_data['description']    = $data['overview'];
          $movie_data['runtime']        = $data['runtime'].' Min';
          $movie_data['stars']          = $this->common_model->get_star_ids('actor',$actors);
          $movie_data['director']       = $this->common_model->get_star_ids('director',$directors);
          $movie_data['writer']         = $this->common_model->get_star_ids('writer',$writters);
          $movie_data['country']        = $this->country_model->get_country_ids($countries);
          $movie_data['genre']          = $this->genre_model->get_genre_ids($genres);
          $movie_data['imdb_rating']    = $data['vote_average'];
          $movie_data['release']        = $data['release_date'];
          $movie_data['video_quality']  = 'HD';
          $movie_data['publication']    = '1';
          $movie_data['enable_download']= '0';
          $movie_data['trailler_youtube_source']         = 'https://www.youtube.com/watch?v='.$this->extract_trailer_youtube_source($data['trailers']['youtube']);
          $this->db->insert('videos',$movie_data);
          $insert_id                    = $this->db->insert_id();
          //save thumbnail
          $image_source                 = 'https://image.tmdb.org/t/p/w300/'.$data['poster_path'];
          $save_to                      = 'uploads/video_thumb/'.$insert_id.'.jpg';           
          $this->common_model->grab_image($image_source,$save_to);
          // save poster
          if($data['backdrop_path'] !='' && $data['backdrop_path'] !=NULL):            
            $image_source                 = 'https://image.tmdb.org/t/p/w1280/'.$data['backdrop_path'];
            $save_to                      = 'uploads/poster_image/'.$insert_id.'.jpg';           
            $this->common_model->grab_image($image_source,$save_to);
          endif;
          // update slug
          $slug                         = url_title($data['title'], 'dash', TRUE);
          $slug_num                     = $this->common_model->slug_num('videos',$slug);
          if($slug_num > 0):
              $slug= $slug.'-'.$insert_id;
          endif;
          $data_update['slug']               = $slug;
          $this->db->where('videos_id', $insert_id);
          $this->db->update('videos', $data_update);

        }else{
          $response      = FALSE;
        }
      }
    return $response;    
  }

  function extract_trailer_youtube_source($youtube_array){
    if($youtube_array):
      foreach ($youtube_array as $yt):
        return $yt['source'];
      endforeach;
    endif;
    return '';
  }

  function import_tvseries_info($tmdb_id=''){
      $response          = TRUE;
      $tmdb_language     =   $this->db->get_where('config' , array('title'=>'tmdb_language'))->row()->value;
      $this->tmdb->setLang($tmdb_language);
      if($tmdb_id =='' || $tmdb_id==NULL):
        $tmdb_id  = '00000000';
      endif;
      $tvshow           = $this->tmdb->getTVShow($tmdb_id);
      $data             = $tvshow ->getJSON();
      $data             = json_decode($data, true);
      if(empty($data)){
        $response      = FALSE;
      }else{
        $actors         = array();
        $directors      = array();
        $writters       = array();
        $countries      = array();
        $genres         = array();
        if(count($data) >0){
          $actors       = $this->filter_actors($data['credits']['cast']);
          $directors    = $this->filter_directors($data['credits']['crew']);
          $writters     = $this->filter_writters($data['credits']['crew']);
          $countries    = $this->filter_tv_countries($data['origin_country']);
          $genres       = $this->filter_genres($data['genres']);
        }
        if(count($data) >0 && $data['name'] !='' && $data['name'] !=NULL){
          $this->get_movie_actor_info($tmdb_id);
          $movie_data['imdbid']         = '';//$data['imdbID'];
          $movie_data['tmdbid']         = $tmdb_id;//$data['imdbID'];
          $movie_data['title']          = $data['name'];
          $movie_data['seo_title']      = $data['name'];
          $movie_data['description']    = $data['overview'];
          $movie_data['runtime']        = '';
          $movie_data['stars']          = $this->common_model->get_star_ids('actor',$actors);
          $movie_data['director']       = $this->common_model->get_star_ids('director',$directors);
          $movie_data['writer']         = $this->common_model->get_star_ids('writer',$writters);
          $movie_data['country']        = $this->country_model->get_country_ids($countries);
          $movie_data['genre']          = $this->genre_model->get_genre_ids($genres);
          $movie_data['imdb_rating']    = $data['vote_average'];
          $movie_data['release']        = $data['first_air_date'];
          $movie_data['video_quality']  = 'HD';
          $movie_data['publication']    = '1';
          $movie_data['enable_download']= '0';
          $movie_data['is_tvseries']    = '1';
          $movie_data['trailler_youtube_source']         = '';
          $this->db->insert('videos',$movie_data);
          $insert_id                    = $this->db->insert_id();
          //save thumbnail
          $image_source                 = 'https://image.tmdb.org/t/p/w300/'.$data['poster_path'];
          $save_to                      = 'uploads/video_thumb/'.$insert_id.'.jpg';           
          $this->common_model->grab_image($image_source,$save_to);
          // save poster
          if($data['backdrop_path'] !='' && $data['backdrop_path'] !=NULL):            
            $image_source                 = 'https://image.tmdb.org/t/p/w1280/'.$data['backdrop_path'];
            $save_to                      = 'uploads/poster_image/'.$insert_id.'.jpg';           
            $this->common_model->grab_image($image_source,$save_to);
          endif;
          // update slug
          $slug                         = url_title($data['name'], 'dash', TRUE);
          $slug_num                     = $this->common_model->slug_num('videos',$slug);
          if($slug_num > 0):
              $slug= $slug.'-'.$insert_id;
          endif;
          $data_update['slug']               = $slug;
          $this->db->where('videos_id', $insert_id);
          $this->db->update('videos', $data_update);

        }else{
          $response      = FALSE;
        }
      }
    return $response;    
  }

  // from v329
  function get_movies_by_title($title){
    $data = array();
    if($title =='' || $title==NULL):
      $title  = '00000000';
    endif;
    $movies          = $this->tmdb->searchMovie($title);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }
  function get_popular_movies($page=1){
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->getPopularMovies($page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function get_top_rated_movies($page=1){
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->getTopRatedMovies($page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function get_upcoming_movies($page=1){
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->getUpcomingMovies($page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function get_movies_by_year($year,$page=1){
    if($year =="" && $year ==NULL && !is_integer($year)){
      $year = date("Y");
    }
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->searchMoviesByYear($year,$page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }


  // tvshows

  function get_tvshows_by_title($title){
      $data = array();
      if($title =='' || $title==NULL):
        $title  = '00000000';
      endif;
      $movies          = $this->tmdb->searchTVShow($title);
      foreach ($movies as $movie):
          $data[] = $movie->getJSON();
      endforeach;
      if(empty($data)):
        $data['error_message']    = 'Not found';
      endif;
      return $data;
  }

  function get_popular_tvshows($page=1){
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->getPopularTVShows($page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function get_top_rated_tvshows($page=1){
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->getTopRatedTVShows($page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function get_upcoming_tvshows($page=1){
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    $data = array();
    $movies          = $this->tmdb->getOnTheAirTVShows($page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function get_tvshows_by_year($year,$page=1){

    if($year =="" && $year ==NULL && !is_integer($year)){
      $year = date("Y");
    }
    if($page =="" && $page ==NULL && !is_integer($page)){
      $page = 1;
    }
    var_dump($year,$page);
    $data = array();
    $movies          = $this->tmdb->searchTVShowsByYear($year,$page);
    foreach ($movies as $movie):
        $data[] = $movie->getJSON();
    endforeach;
    if(empty($data)):
      $data['error_message']    = 'Not found';
    endif;
    return $data;
  }

  function movie_by_title($title='',$to=''){
      $data = array();
      $purchase_code  = trim($this->db->get_where('config' , array('title'=>'purchase_code'))->row()->value ?? "");
      if($purchase_code =='' || $purchase_code==NULL):
        $purchase_code  = '123456987123';
      endif;
      if($title =='' || $title==NULL):
        $title  = '00000000';
      endif;
      if($to =='tv'):
        $tvshows          = $this->tmdb->searchTVShow($title);
        foreach ($tvshows as $tvshow):
            $data[] = $tvshow->getJSON();
        endforeach;
      else:
        $movies          = $this->tmdb->getDiscoverMovies(1);
        foreach ($movies as $movie):
            $data[]       = $movie->getJSON();
        endforeach;        
      endif;
      if(empty($data)):
        $data['error_message']    = 'Not found';
      endif;
    return $data;
  }
  
}

