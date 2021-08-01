 <div class="row">
    <div class="col-lg-12">
        <h1><?php echo $article['title']; ?></h1>
        <?php echo $this->shortcode->run($article['body']); ?>
    </div>
</div>

