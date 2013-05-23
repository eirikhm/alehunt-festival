var App = (function () {
    function App() {
        var self = this;
        rivets.configure({
            adapter: {
                subscribe: function (obj, keypath, callback) {
                    obj.on('change:' + keypath, callback);
                },
                unsubscribe: function (obj, keypath, callback) {
                    obj.off('change:' + keypath, callback);
                },
                read: function (obj, keypath) {
                    return obj.get(keypath);
                },
                publish: function (obj, keypath, value) {
                    obj.set(keypath, value);
                }
            }
        });
        rivets.formatters.moneyNok = {
            read: function (value) {
                return value / 100 + " NOK";
            },
            publish: function (value) {
                return value * 100;
            }
        };
        var dm = new DataManager();
        dm.loadData(function () {
            self.loadTemplates('tpl.php', function () {
                self.router = new Router(self);
                Backbone.history.start({
                    pushState: false
                });
            });
        });
    }
    App.prototype.loadTemplates = function (url, callback) {
        var templateId = null;
        var templateMarkup = null;

        $.get(url, function (data) {
            data = $.parseHTML(data);
            $(data).each(function (index, element) {
                if(element.nodeName == 'SCRIPT') {
                    templateId = element.id;
                    templateMarkup = $(element).html();
                    var t = dust.compile(templateMarkup, templateId);
                    dust.loadSource(t);
                }
            });
            if(typeof callback === 'function') {
                callback();
            }
        });
    };
    return App;
})();
//@ sourceMappingURL=App.js.map
