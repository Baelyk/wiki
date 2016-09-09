var MarkdownIt = require('markdown-it'),
    md = new MarkdownIt();
var output; // = md.render("# hi");

process.argv.forEach(function (val, index, array) {
    if(index == 2) {
        output = md.render(val);
    }
});

console.log(output);
