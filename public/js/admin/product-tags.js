define([], function(){
    var self = {};

    // 标签关联的数据表,也就是标签的类型
    self.recordTable = '';
    self.obj = '';
    self.productTags = [];

    self.init = function(options) {
        $.extend(self, options);

        self.obj
            .select2({
                tags: true,
                tokenSeparators: [',', ' '],
                createSearchChoice: function(term, data) {
                    if ($(data).filter(function() {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                        return {
                            id: term,
                            text: term
                        };
                    }
                },
                multiple: true,
                closeOnSelect: false,
                ajax: {
                    url: $.url('admin/tag.json', {recordTable: self.recordTable}),
                    dataType: "json",
                    data: function(term, page) {
                        return {
                            search: term,
                            rows: 20
                        };
                    },
                    results: function(data, page) {
                        var tags = [];
                        for (var i in data.data) {
                            tags.push({id: data.data[i]['id'], text: data.data[i]['name']});
                        }
                        return {
                            results: tags
                        };
                    }
                }
            })
            .on('select2-selecting', function(e) {
                // 新增的标签
                if (e.object.id == e.object.text) {
                    $.ajax({
                        async: false,
                        url: $.url('admin/tag/create'),
                        dataType: 'json',
                        data:  {
                            name: e.object.text,
                            recordTable: self.recordTable
                        },
                        success: function(result) {
                            e.object.id = result.data.id;
                        }
                    });
                }
            });

        // 初始化已有的标签
        var data = [];
        $(self.productTags).each(function(index, row) {
            data.push({ id: row.id, text: row.name });
        });
        self.obj.select2('data', data);
    };
    return self;
});
