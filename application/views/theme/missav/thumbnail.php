<?php
    $assets_dir = 'assets/theme/default/';
?>
<div class="group">
    <div class="relative aspect-video rounded overflow-hidden shadow-lg">
        <a href="<?php echo base_url('watch/' . $videos['slug']) . '.html'; ?>" alt="<?php echo $videos['title']; ?>">
            <img class="w-full h-auto aspect-video" alt="<?php echo $videos['title']; ?>"
                src="<?php echo $this->common_model->get_video_poster_url($videos['videos_id']); ?>">
        </a>
        <a href="<?php echo base_url('watch/' . $videos['slug']) . '.html'; ?>" alt="<?php echo $videos['title']; ?>">
            <span class="absolute bottom-1 right-1 rounded-lg px-2 py-1 text-xs text-nord5 bg-gray-800 bg-opacity-75">
                <span>
                    <?php echo $videos['runtime']; ?>
                </span>
        </a>
    </div>
    <div class="my-2 text-sm truncate text-gray-300">
        <a class="text-secondary group-hover:text-pink-500"
            href="<?php echo base_url('watch/' . $videos['slug']) . '.html'; ?>">
            <?php echo $videos['title']; ?>
        </a>
    </div>
</div>