// XMLbuilder.js

function xmlEscape(s) {
//document.write("Entrou no XMLbuilder.js ---function xmlEscape(s)");
    return s.replace(/[<>&"]/g, function (c) {
        return "&"
            + { "<": "lt", ">": "gt", "&": "amp", "\"": "quot" }[c]
            + ";";
    });
}

var xml = [ "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" ];

xml.text = function () {
    Array.prototype.push.apply(this, arguments); //É usada a framework prototype
    return this;
};

xml.elem = function (tagName, attrs, selfClose) { 
//document.write("Entrou no XMLbuilder.js --- xml.elem = function (tagName, attrs, selfClose)!!!");

    this.text("<", tagName);

    for (var a in attrs || {}) {
        this.text(" ", a, "=\"", xmlEscape(String(attrs[a])), "\"");
    }

    this.text(selfClose ? "/" : "", ">\n");

    return this;
};

xml.toString = function () {
 return this.join(""); 
 }
