/*!
 * @project        nystudio107
 * @name           dashboard.8a6276545fd017ab1ebf.js
 * @author         andrew@nystudio107.com
 * @build          Tue, Sep 11, 2018 9:45 PM ET
 * @release        7b62fa8837e3677e0c2774d48eff310ccf867932 [develop]
 * @copyright      Copyright (c) 2018 nystudio107
 *
 */!function(e){function t(t){for(var n,o,a=t[0],u=t[1],l=0,c=[];l<a.length;l++)o=a[l],r[o]&&c.push(r[o][0]),r[o]=0;for(n in u)Object.prototype.hasOwnProperty.call(u,n)&&(e[n]=u[n]);for(i&&i(t);c.length;)c.shift()()}var n={},r={2:0};function o(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,o),r.l=!0,r.exports}o.e=function(e){var t=[],n=r[e];if(0!==n)if(n)t.push(n[2]);else{var a=new Promise(function(t,o){n=r[e]=[t,o]});t.push(n[2]=a);var u,l=document.getElementsByTagName("head")[0],i=document.createElement("script");i.charset="utf-8",i.timeout=120,o.nc&&i.setAttribute("nonce",o.nc),i.src=function(e){return o.p+"js/"+({0:"styles",1:"vendors~confetti~vue",7:"vue-events",8:"confetti",9:"dashboard-chart",10:"dashboard-table",14:"vendors~axios",15:"vendors~vuetable",16:"vendors~apexcharts"}[e]||e)+"."+{0:"a63657b109d46e040788",1:"a50dc4024cc84cf14552",7:"c9a1132e957dad5d55b2",8:"c0450ee8c2b8fb9c9be6",9:"2359521a4a866b89dae4",10:"19fed74316735bb597e3",14:"ccdde19959f052460121",15:"1f9f53a55f195e9b4184",16:"fd4be3dfdf14e5f5b7d6"}[e]+".js"}(e),u=function(t){i.onerror=i.onload=null,clearTimeout(c);var n=r[e];if(0!==n){if(n){var o=t&&("load"===t.type?"missing":t.type),a=t&&t.target&&t.target.src,u=new Error("Loading chunk "+e+" failed.\n("+o+": "+a+")");u.type=o,u.request=a,n[1](u)}r[e]=void 0}};var c=setTimeout(function(){u({type:"timeout",target:i})},12e4);i.onerror=i.onload=u,l.appendChild(i)}return Promise.all(t)},o.m=e,o.c=n,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)o.d(n,r,function(t){return e[t]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/cpresources/retour/",o.oe=function(e){throw console.error(e),e};var a=window.webpackJsonp=window.webpackJsonp||[],u=a.push.bind(a);a.push=t,a=a.slice();for(var l=0;l<a.length;l++)t(a[l]);var i=u;o(o.s=4)}({4:function(e,t,n){(async()=>{const e=await n.e(1).then(n.bind(null,1)),t=await n.e(7).then(n.t.bind(null,3,7));e.default.use(t.default);new e.default({el:"#cp-nav-content",components:{confetti:()=>Promise.all([n.e(0),n.e(1),n.e(8)]).then(n.bind(null,16)),"dashboard-chart":()=>Promise.all([n.e(0),n.e(9)]).then(n.bind(null,17)),"dashboard-table":()=>Promise.all([n.e(0),n.e(10)]).then(n.bind(null,19))},data:{},methods:{onTableRefresh(t){console.log("onTableRefresh"),e.default.nextTick(()=>t.refresh())}},mounted(){this.$events.$on("refresh-table",e=>this.onTableRefresh(e))}})})().then({})}});
//# sourceMappingURL=dashboard.8a6276545fd017ab1ebf.js.map