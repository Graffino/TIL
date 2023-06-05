window.Rx = require("rxjs");
window.hljs = require("highlight.js");
window.Cookies = require("js-cookie");

window.CodeMirror = require("codemirror/lib/codemirror");
require("codemirror/keymap/vim");
require("codemirror/keymap/emacs");

import {removeTrailingSlash} from "./utils";

hljs.highlightAll();

import Echo from "laravel-echo";

const domainName = removeTrailingSlash(document.head.querySelector(
    'meta[name="domain-name"]'
).content);

window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_HOST,
    cluster: 'mt1',
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ["ws", "wss"],
    authEndpoint: `${domainName}/broadcasting/auth`,
});
