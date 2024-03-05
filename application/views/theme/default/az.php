<style type="text/css">
    .az-list{
        color: #777;
    }
    .az-list ul.letters {
        margin: 0;
        padding: 0;
        margin-bottom: 15px;
        overflow: hidden;
    }
    .az-list ul.letters li {
        margin: 0;
        padding: 0;
        float: left;
        list-style: none;
        /*width: 3.7037%;*/
        margin-right: 8px;
        margin-top: 5px;
        width: 34px;
    }
    .az-list ul.letters li.first-latter {
        margin-right: 4px;
        width: 42px;
    }

    .az-list ul.letters li.last-latter {
        margin-right: 0px;
    }
    .az-list table tbody>tr>td:nth-child(1), .az-list table thead>tr>td:nth-child(1) {
        text-align: center;
    }

    .az-list table tbody td {
        vertical-align: middle;
    }
    .az-list table tbody .thumb {
        width: 35px;
        height: 45px;
        margin-right: 5px;
    }
    .az-list table tbody .name {
        color: #8e95a5;
        font-weight: 500;
    }

    .az-list table tbody a {
        color: #8e95a5;
    }
</style>
<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <div class="container">
        <div class="widget az-list">
            <div class="widget-title">
                <h1>Movies By Letter</h1> </div>
            <ul class="letters">
                <li class="first-latter"><a class="btn <?php if($param1=='' || $param1=='09'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/09') ?>">0-9</a></li>
                <li><a class="btn <?php if($param1=='a' || $param1=='A'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/a') ?>">A</a></li>
                <li><a class="btn <?php if($param1=='b' || $param1=='B'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/b') ?>">B</a></li>
                <li><a class="btn <?php if($param1=='c' || $param1=='C'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/c') ?>">C</a></li>
                <li><a class="btn <?php if($param1=='d' || $param1=='D'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/d') ?>">D</a></li>
                <li><a class="btn <?php if($param1=='e' || $param1=='E'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/e') ?>">E</a></li>
                <li><a class="btn <?php if($param1=='f' || $param1=='F'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/f') ?>">F</a></li>
                <li><a class="btn <?php if($param1=='g' || $param1=='G'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/g') ?>">G</a></li>
                <li><a class="btn <?php if($param1=='h' || $param1=='H'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/h') ?>">H</a></li>
                <li><a class="btn <?php if($param1=='i' || $param1=='I'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/i') ?>">I</a></li>
                <li><a class="btn <?php if($param1=='j' || $param1=='j'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/j') ?>">j</a></li>
                <li><a class="btn <?php if($param1=='k' || $param1=='K'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/k') ?>">K</a></li>
                <li><a class="btn <?php if($param1=='l' || $param1=='L'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/l') ?>">L</a></li>
                <li><a class="btn <?php if($param1=='m' || $param1=='M'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/m') ?>">M</a></li>
                <li><a class="btn <?php if($param1=='n' || $param1=='N'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/n') ?>">N</a></li>
                <li><a class="btn <?php if($param1=='o' || $param1=='O'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/o') ?>">O</a></li>
                <li><a class="btn <?php if($param1=='p' || $param1=='P'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/p') ?>">P</a></li>
                <li><a class="btn <?php if($param1=='q' || $param1=='Q'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/q') ?>">Q</a></li>
                <li><a class="btn <?php if($param1=='r' || $param1=='R'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/r') ?>">R</a></li>
                <li><a class="btn <?php if($param1=='s' || $param1=='S'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/s') ?>">S</a></li>
                <li><a class="btn <?php if($param1=='t' || $param1=='T'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/t') ?>">T</a></li>
                <li><a class="btn <?php if($param1=='u' || $param1=='U'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/u') ?>">U</a></li>
                <li><a class="btn <?php if($param1=='v' || $param1=='V'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/v') ?>">V</a></li>
                <li><a class="btn <?php if($param1=='w' || $param1=='W'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/w') ?>">W</a></li>
                <li><a class="btn <?php if($param1=='x' || $param1=='X'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/x') ?>">X</a></li>
                <li><a class="btn <?php if($param1=='y' || $param1=='Y'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/y') ?>">Y</a></li>
                <li class="last-latter"><a class="btn <?php if($param1=='z' || $param1=='Z'): echo "btn-primary"; else: echo "btn-default"; endif; ?>" href="<?php echo base_url('az-list/z') ?>">Z</a></li>
            </ul>
            <div class="widget-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td><?php echo $total_rows; ?> results</td>
                            <td>Year</td>
                            <td>Quality</td>
                            <td>Country</td>
                            <td>Genre</td>
                            <td>IMDb</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i =    0 ;
                            foreach ($all_videos as $videos):
                            $i++;
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td> <img class="thumb" src="<?php echo $this->common_model->get_video_thumb_url($videos['videos_id']); ?>" alt="<?php echo $videos['title'];?>"> <a class="name" href="<?php echo base_url('watch/'.$videos['slug']).'.html';?>" title="<?php echo $videos['title'];?>"><?php echo $videos['title'];?></a> </td>
                                <td><?php echo date("Y",strtotime($videos['release']));?></td>
                                <td><?php echo ($videos['video_quality'] =='' || $videos['video_quality'] == NULL) ? $videos['video_quality'] : 'HD';?></td>
                                <td> <?php echo $this->country_model->generate_countries_anchor($videos['country']); ?></td>
                                <td> <?php echo $this->genre_model->generate_genres_anchor($videos['genre']); ?> </td>
                                <td><span class="imdb"><?php echo $videos['imdb_rating'];?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center">
                    <?php echo $links; ?>
                </div>
            </div>
        </div>
    </div>
</section>