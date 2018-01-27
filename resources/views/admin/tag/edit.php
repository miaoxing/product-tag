<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/tag/index') ?>">返回列表</a>

  <h1>
    标签管理
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="product-tag-form" class="form-horizontal" method="post" role="form">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="record-table">
          <span class="text-warning">*</span>
          类型
        </label>

        <div class="col-lg-4">
          <select class="form-control" name="recordTable" id="record-table">
            <option value="product">商品</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          <span class="text-warning">*</span>
          名称
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="name" id="name" data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="color">
          <span class="text-warning">*</span>
          颜色
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="color" id="color" data-rule-required="true">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="enable">
          状态
        </label>

        <div class="col-lg-4">
          <label class="radio-inline">
            <input type="radio" name="enable" value="1" checked> 显示
          </label>
          <label class="radio-inline">
            <input type="radio" name="enable" value="0"> 不显示
          </label>

        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="sort">
          顺序
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="sort" id="sort">
        </div>

        <label class="col-lg-6 help-text" for="no">
          大的显示在前面,按从大到小排列.
        </label>
      </div>

      <input type="hidden" name="id" id="id"/>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/tag/index') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>
    </form>
  </div>
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require(['form', 'validator', 'assets/spectrum'], function () {
    $('#product-tag-form')
      .loadJSON(<?= $tag->toJson() ?>)
      .ajaxForm({
        url: '<?= $url('admin/tag/' . $tag->getFormAction()) ?>',
        dataType: 'json',
        beforeSubmit: function (arr, $form, options) {
          return $form.valid();
        },
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/tag/index');
            }
          });
        }
      })
      .validate();

    $('#color').spectrum();
  });
</script>
<?= $block->end() ?>
