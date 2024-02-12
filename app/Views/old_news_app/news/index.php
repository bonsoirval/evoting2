<h2><?php print(esc($title)); ?></h2>
<?php if (!empty($news) && is_array($news)): ?>
    <?php foreach($news as $news_item): ?>
        <h3><?php print esc($news_item['title']); ?></h3>
        <div class='main'>
            <?php print(esc($news_item['body'])) ?>
        <div>
            <p><a href="/news/<?php print(esc($news_item['slug'], 'url')); ?>">View article</a></p>
        <?php endforeach ?>
    <?php else: ?>
        <h3>Now News</h3>
        <p>Unable to find any news for you.</p>
    <?php endif ?>
    </div>