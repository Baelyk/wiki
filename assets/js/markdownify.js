var Emoji = require('markdown-it-emoji');
var Abbr = require('markdown-it-abbr');
var Foot = require('markdown-it-footnote');
var Sub = require('markdown-it-sub');
var Sup = require('markdown-it-sup');
var TContents = require('markdown-it-table-of-contents');
var Anch = require('markdown-it-anchor');
var FontAwesome = require('markdown-it-fontawesome');
var Attrs = require('markdown-it-attrs');

var MarkdownIt = require('markdown-it')()
    .use(Emoji)
    .use(Abbr)
    .use(Foot)
    .use(Sub)
    .use(Sup)
    .use(TContents)
    .use(Anch)
    .use(FontAwesome)
    .use(Attrs);
// var md = new MarkdownIt();
var output; // = md.render("# hi");

process.argv.forEach(function (val, index, array) {
    if(index == 2) {
        output = MarkdownIt.render(val);
    }
});

console.log(output);
