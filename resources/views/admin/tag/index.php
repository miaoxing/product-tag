<?php $view->layout() ?>

<div class="page-header">
  <a class="btn pull-right btn-success" href="<?= $url('admin/tag/new') ?>">添加标签</a>

  <h1>
    标签管理
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="well form-well">
      <form class="js-tag-form form-inline" role="form">
        <div class="form-group">
          <select id="enable" name="enable">
            <option value="">全部状态</option>
            <option value="1">显示</option>
            <option value="0">不显示</option>
          </select>
        </div>
      </form>
    </div>

    <div class="table-responsive">
      <table id="record-table" class="record-table table table-bordered table-hover">
        <thead>
          <tr>
            <th>名称</th>
            <th>状态</th>
            <th>顺序</th>
            <th>修改时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <a href="<%= $.url('products', {tags: id}) %>" target="_blank" title="查看该标签的商品">
      查看商品
    </a>
    <a href="<%= $.url('admin/tag/edit', {id: id}) %>">
      编辑
    </a>
    <a class="text-danger delete-record" href="javascript:;" data-href="<%= $.url('admin/tag/destroy', {id: id}) %>">
      删除
    </a>
  </div>
</script>

<?= $block->js() ?>
<script>
  require(['dataTable', 'form', 'jquery-deparam'], function () {
    $('#search-form').loadParams().update(function () {
      recordTable.reload($(this).serialize());
    });

    var recordTable = $('#record-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/tag.json')
      },
      columns: [
        {
          data: 'name',
          render: function (data, type, full) {
            return '<span class="badge text-white" style="background-color: ' + full.color + '!important">' + data + '</span>';
          }
        },
        {
          data: 'enable',
          render: function (data, type, full) {
            if (data == 1) {
              return '显示';
            }
            return '不显示';
          }
        },
        {
          data: 'sort'
        },
        {
          data: 'updateTime'
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('table-actions', full)
          }
        }
      ]
    });

    // 点击删除标签
    recordTable.on('click', '.delete-record', function () {
      var link = $(this);
      $.confirm('删除后将无法还原,确认删除?', function () {
        $.post(link.data('href'), function (result) {
          $.msg(result);
          recordTable.reload();
        }, 'json');
      });
    });

    $('.js-tag-form').update(function () {
      recordTable.reload($(this).serialize(), false);
    });
  });
</script>
<?= $block->end() ?>
