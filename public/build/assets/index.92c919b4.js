import{U as x,g as C,a as D,i as M,S as P,b as q}from"./_Uint8Array.27af0212.js";import{M as J,w as H,L as K,x as I,t as m,J as Q}from"./index.412eb292.js";import{af as X}from"./app.8ff0f107.js";var Y="__lodash_hash_undefined__";function Z(n){return this.__data__.set(n,Y),this}function W(n){return this.__data__.has(n)}function L(n){var e=-1,r=n==null?0:n.length;for(this.__data__=new J;++e<r;)this.add(n[e])}L.prototype.add=L.prototype.push=Z;L.prototype.has=W;function b(n,e){for(var r=-1,s=n==null?0:n.length;++r<s;)if(e(n[r],r,n))return!0;return!1}function z(n,e){return n.has(e)}var j=1,V=2;function N(n,e,r,s,t,a){var f=r&j,i=n.length,l=e.length;if(i!=l&&!(f&&l>i))return!1;var d=a.get(n),v=a.get(e);if(d&&v)return d==e&&v==n;var p=-1,u=!0,o=r&V?new L:void 0;for(a.set(n,e),a.set(e,n);++p<i;){var g=n[p],_=e[p];if(s)var c=f?s(_,g,p,e,n,a):s(g,_,p,n,e,a);if(c!==void 0){if(c)continue;u=!1;break}if(o){if(!b(e,function(T,y){if(!z(o,y)&&(g===T||t(g,T,r,s,a)))return o.push(y)})){u=!1;break}}else if(!(g===_||t(g,_,r,s,a))){u=!1;break}}return a.delete(n),a.delete(e),u}function k(n){var e=-1,r=Array(n.size);return n.forEach(function(s,t){r[++e]=[t,s]}),r}function nn(n){var e=-1,r=Array(n.size);return n.forEach(function(s){r[++e]=s}),r}var en=1,rn=2,an="[object Boolean]",sn="[object Date]",tn="[object Error]",fn="[object Map]",un="[object Number]",ln="[object RegExp]",dn="[object Set]",gn="[object String]",pn="[object Symbol]",vn="[object ArrayBuffer]",on="[object DataView]",B=H?H.prototype:void 0,R=B?B.valueOf:void 0;function _n(n,e,r,s,t,a,f){switch(r){case on:if(n.byteLength!=e.byteLength||n.byteOffset!=e.byteOffset)return!1;n=n.buffer,e=e.buffer;case vn:return!(n.byteLength!=e.byteLength||!a(new x(n),new x(e)));case an:case sn:case un:return K(+n,+e);case tn:return n.name==e.name&&n.message==e.message;case ln:case gn:return n==e+"";case fn:var i=k;case dn:var l=s&en;if(i||(i=nn),n.size!=e.size&&!l)return!1;var d=f.get(n);if(d)return d==e;s|=rn,f.set(n,e);var v=N(i(n),i(e),s,t,a,f);return f.delete(n),v;case pn:if(R)return R.call(n)==R.call(e)}return!1}var cn=1,An=Object.prototype,Tn=An.hasOwnProperty;function yn(n,e,r,s,t,a){var f=r&cn,i=C(n),l=i.length,d=C(e),v=d.length;if(l!=v&&!f)return!1;for(var p=l;p--;){var u=i[p];if(!(f?u in e:Tn.call(e,u)))return!1}var o=a.get(n),g=a.get(e);if(o&&g)return o==e&&g==n;var _=!0;a.set(n,e),a.set(e,n);for(var c=f;++p<l;){u=i[p];var T=n[u],y=e[u];if(s)var S=f?s(y,T,u,e,n,a):s(T,y,u,n,e,a);if(!(S===void 0?T===y||t(T,y,r,s,a):S)){_=!1;break}c||(c=u=="constructor")}if(_&&!c){var E=n.constructor,w=e.constructor;E!=w&&"constructor"in n&&"constructor"in e&&!(typeof E=="function"&&E instanceof E&&typeof w=="function"&&w instanceof w)&&(_=!1)}return a.delete(n),a.delete(e),_}var En=1,$="[object Arguments]",G="[object Array]",O="[object Object]",wn=Object.prototype,U=wn.hasOwnProperty;function On(n,e,r,s,t,a){var f=I(n),i=I(e),l=f?G:D(n),d=i?G:D(e);l=l==$?O:l,d=d==$?O:d;var v=l==O,p=d==O,u=l==d;if(u&&M(n)){if(!M(e))return!1;f=!0,v=!1}if(u&&!v)return a||(a=new P),f||q(n)?N(n,e,r,s,t,a):_n(n,e,l,r,s,t,a);if(!(r&En)){var o=v&&U.call(n,"__wrapped__"),g=p&&U.call(e,"__wrapped__");if(o||g){var _=o?n.value():n,c=g?e.value():e;return a||(a=new P),t(_,c,r,s,a)}}return u?(a||(a=new P),yn(n,e,r,s,t,a)):!1}function h(n,e,r,s,t){return n===e?!0:n==null||e==null||!m(n)&&!m(e)?n!==n&&e!==e:On(n,e,r,s,h,t)}function Sn(n,e){return h(n,e)}const A=new Map;if(X){let n;document.addEventListener("mousedown",e=>n=e),document.addEventListener("mouseup",e=>{if(n){for(const r of A.values())for(const{documentHandler:s}of r)s(e,n);n=void 0}})}function F(n,e){let r=[];return Array.isArray(e.arg)?r=e.arg:Q(e.arg)&&r.push(e.arg),function(s,t){const a=e.instance.popperRef,f=s.target,i=t==null?void 0:t.target,l=!e||!e.instance,d=!f||!i,v=n.contains(f)||n.contains(i),p=n===f,u=r.length&&r.some(g=>g==null?void 0:g.contains(f))||r.length&&r.includes(i),o=a&&(a.contains(f)||a.contains(i));l||d||v||p||u||o||e.value(s,t)}}const xn={beforeMount(n,e){A.has(n)||A.set(n,[]),A.get(n).push({documentHandler:F(n,e),bindingFn:e.value})},updated(n,e){A.has(n)||A.set(n,[]);const r=A.get(n),s=r.findIndex(a=>a.bindingFn===e.oldValue),t={documentHandler:F(n,e),bindingFn:e.value};s>=0?r.splice(s,1,t):r.push(t)},unmounted(n){A.delete(n)}};export{xn as C,L as S,h as b,z as c,Sn as i,nn as s};
