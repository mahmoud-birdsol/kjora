import{an as y}from"./app.8ff0f107.js";import{s as l,t as h,v as w,w as u,x as v,y as p,A as O,B as S,C as P,j as T,b as A}from"./index.412eb292.js";function I(n){return n}function _(n,e,r){switch(r.length){case 0:return n.call(e);case 1:return n.call(e,r[0]);case 2:return n.call(e,r[0],r[1]);case 3:return n.call(e,r[0],r[1],r[2])}return n.apply(e,r)}var x=800,k=16,N=Date.now;function C(n){var e=0,r=0;return function(){var a=N(),t=k-(a-r);if(r=a,t>0){if(++e>=x)return arguments[0]}else e=0;return n.apply(void 0,arguments)}}function E(n){return function(){return n}}var $=l?function(n,e){return l(n,"toString",{configurable:!0,enumerable:!1,value:E(e),writable:!0})}:I;const F=$;var G=C(F);const H=G;var f=Math.max;function L(n,e,r){return e=f(e===void 0?n.length-1:e,0),function(){for(var a=arguments,t=-1,i=f(a.length-e,0),s=Array(i);++t<i;)s[t]=a[e+t];t=-1;for(var o=Array(e+1);++t<e;)o[t]=a[t];return o[e]=r(s),_(n,this,o)}}var M=9007199254740991;function R(n){return typeof n=="number"&&n>-1&&n%1==0&&n<=M}var B="[object Arguments]";function c(n){return h(n)&&w(n)==B}var m=Object.prototype,z=m.hasOwnProperty,D=m.propertyIsEnumerable,K=c(function(){return arguments}())?c:function(n){return h(n)&&z.call(n,"callee")&&!D.call(n,"callee")};const b=K;function U(n,e){for(var r=-1,a=e.length,t=n.length;++r<a;)n[t+r]=e[r];return n}var g=u?u.isConcatSpreadable:void 0;function X(n){return v(n)||b(n)||!!(g&&n&&n[g])}function d(n,e,r,a,t){var i=-1,s=n.length;for(r||(r=X),t||(t=[]);++i<s;){var o=n[i];e>0&&r(o)?e>1?d(o,e-1,r,a,t):U(t,o):a||(t[t.length]=o)}return t}function q(n){var e=n==null?0:n.length;return e?d(n,1):[]}function J(n){return H(L(n,void 0,q),n+"")}function Q(n,e){return n!=null&&e in Object(n)}function V(n,e,r){e=p(e,n);for(var a=-1,t=e.length,i=!1;++a<t;){var s=O(e[a]);if(!(i=n!=null&&r(n,s)))break;n=n[s]}return i||++a!=t?i:(t=n==null?0:n.length,!!t&&R(t)&&S(s,t)&&(v(n)||b(n)))}function W(n,e){return n!=null&&V(n,e,Q)}function Y(n,e,r){for(var a=-1,t=e.length,i={};++a<t;){var s=e[a],o=P(n,s);r(o,s)&&T(i,p(s,n),o)}return i}function Z(n,e){return Y(n,e,function(r,a){return W(n,a)})}var j=J(function(n,e){return n==null?{}:Z(n,e)});const nn=j,an=(n,e)=>{if(n.install=r=>{for(const a of[n,...Object.values(e!=null?e:{})])r.component(a.name,a)},e)for(const[r,a]of Object.entries(e))n[r]=a;return n},sn=n=>(n.install=y,n),en=A({ariaLabel:String,ariaOrientation:{type:String,values:["horizontal","vertical","undefined"]},ariaControls:String}),on=n=>nn(en,n);var ln=(n,e)=>{const r=n.__vccOpts||n;for(const[a,t]of e)r[a]=t;return r};export{ln as _,sn as a,b,U as c,I as d,d as e,q as f,W as h,R as i,L as o,H as s,on as u,an as w};
