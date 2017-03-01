<?php
$tags = explode(',', (string) $req['tags']);
?>

<form class="form">
  <div class="form-group">
    <div class="col-control">
      <?php foreach (wei()->tag()->findAll() as $tag) : ?>
        <div class="checkbox checkbox-circle checkbox-success border-bottom">
          <label>
            <input class="js-product-tag" type="checkbox" name="tags[]"
                   value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $tags) ? 'checked' : '' ?>>
            <span class="checkbox-label"><?= $tag['name'] ?></span>
          </label>
        </div>
      <?php endforeach ?>
    </div>
  </div>
  <div class="tag-from-group p-y-sm text-center">
    <button class="js-product-tag-ok btn btn-primary hairline" type="button">确定</button>
    &nbsp;
    <a class="btn btn-default hairline" href="<?= $url->query(ltrim($req->getPathInfo(), '/'), ['tags' => '']) ?>">取消选择</a>
  </div>
</form>

<?= $block('js') ?>
<script>
  // 选中标签,点击确定
  $('.js-product-tag-ok').click(function () {
    var tags = [];
    $('.js-product-tag:checked').each(function () {
      tags.push($(this).val());
    });
    window.location = window.location + (window.location.href.indexOf('?') == -1 ? '?' : '&') + 'tags=' + tags.join(',');
  });
</script>
<?= $block->end() ?>
