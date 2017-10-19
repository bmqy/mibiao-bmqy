// 域名验证
jQuery.validator.addMethod("isDomain", function(value, element) {
    var domain = /(([a-zA-Z0-9_-])+)*(\.(\w)+)$/i;
    return this.optional(element) || (domain.test(value));
}, "请检查域名是否正确");