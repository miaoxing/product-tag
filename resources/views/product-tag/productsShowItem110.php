<dl class="product-item border-top">
  <dt>标签：</dt>
  <dd>
    <?php foreach ($product->getTags() as $tag) : ?>
      <?php if ($tag['enable']) : ?>
        <a href="<?= $url('products', ['tags' => $tag['id']]) ?>" class="product-tag"
          style="background-color: <?= $tag['color'] ?: '#777' ?>"><?= $tag['name'] ?></a>
      <?php endif ?>
    <?php endforeach ?>
  </dd>
</dl>
