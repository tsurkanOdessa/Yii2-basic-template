(function($)
{
    $.Redactor.prototype.addbr = function()
    {
        return {
            init: function()
            {
                var button = this.button.addAfter('html', 'addbr fa fa-terminal', 'Вставить поле с br');
                this.button.addCallback(button, this.addbr.insert);
            },
            insert: function () {
                var data = '<br>';
                this.selection.restore();
                this.insert.html(data);
                this.code.sync();
            }
        };
    };
})(jQuery);