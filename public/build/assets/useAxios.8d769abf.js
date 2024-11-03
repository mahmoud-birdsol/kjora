import{_ as J}from"./AppSearchInput.vue_vue_type_script_setup_true_lang.77cc1d10.js";import{B as H,N as M,o as z,d as K,b as V,a as Q,w as X,f as Y,t as Z,s as ee,u as te,y as L,S as $,l as ne,aj as R,r as P}from"./app.8ff0f107.js";import{_ as oe}from"./Avatar.vue_vue_type_style_index_0_lang.13aa623b.js";const{Axios:ue,AxiosError:U,CanceledError:ce,isCancel:fe,CancelToken:me,VERSION:de,all:pe,Cancel:he,isAxiosError:ve,spread:ye,toFormData:_e,AxiosHeaders:we,HttpStatusCode:Ce,formToJSON:be,getAdapter:Ae,mergeConfig:ge}=H,re={class:"flex items-center gap-3"},Te=M({__name:"PlayerSimpleCard",props:{player:{}},setup(e){return(o,n)=>{const u=oe,p=ee,y=J;return z(),K("div",re,[V(u,{id:o.player.id,username:o.player.username,imageUrl:o.player.avatar_url},null,8,["id","username","imageUrl"]),Q("div",null,[V(p,{href:o.route("player.profile",o.player.id),class:"text-sm font-medium"},{default:X(()=>[Y(Z(`${o.player.first_name} ${o.player.last_name}`),1)]),_:1},8,["href"]),V(y,{modelValue:Number(o.player.rating),disabled:"",showRatingValue:""},null,8,["modelValue"])])])}}});function A(e){return typeof e=="function"?e():te(e)}typeof WorkerGlobalScope<"u"&&globalThis instanceof WorkerGlobalScope;const j=()=>{};function G(e,o=!1,n="Timeout"){return new Promise((u,p)=>{setTimeout(o?()=>p(n):u,e)})}function k(e,o=!1){function n(t,{flush:l="sync",deep:c=!1,timeout:f,throwOnTimeout:h}={}){let a=null;const d=[new Promise(i=>{a=L(e,m=>{t(m)!==o&&(a?a():$(()=>a==null?void 0:a()),i(m))},{flush:l,deep:c,immediate:!0})})];return f!=null&&d.push(G(f,h).then(()=>A(e)).finally(()=>a==null?void 0:a())),Promise.race(d)}function u(t,l){if(!ne(t))return n(m=>m===t,l);const{flush:c="sync",deep:f=!1,timeout:h,throwOnTimeout:a}=l!=null?l:{};let s=null;const i=[new Promise(m=>{s=L([e,t],([w,B])=>{o!==(w===B)&&(s?s():$(()=>s==null?void 0:s()),m(w))},{flush:c,deep:f,immediate:!0})})];return h!=null&&i.push(G(h,a).then(()=>A(e)).finally(()=>(s==null||s(),A(e)))),Promise.race(i)}function p(t){return n(l=>Boolean(l),t)}function y(t){return u(null,t)}function _(t){return u(void 0,t)}function C(t){return n(Number.isNaN,t)}function g(t,l){return n(c=>{const f=Array.from(c);return f.includes(t)||f.includes(A(t))},l)}function T(t){return b(1,t)}function b(t=1,l){let c=-1;return n(()=>(c+=1,c>=t),l)}return Array.isArray(A(e))?{toMatch:n,toContains:g,changed:T,changedTimes:b,get not(){return k(e,!o)}}:{toMatch:n,toBe:u,toBeTruthy:p,toBeNull:y,toBeNaN:C,toBeUndefined:_,changed:T,changedTimes:b,get not(){return k(e,!o)}}}function ae(e){return k(e)}function Be(...e){const o=typeof e[0]=="string"?e[0]:void 0,n=typeof o=="string"?1:0,u={immediate:!!n,shallow:!0,abortPrevious:!0};let p={},y=H,_=u;const C=r=>!!(r!=null&&r.request);e.length>0+n&&(C(e[0+n])?y=e[0+n]:p=e[0+n]),e.length>1+n&&C(e[1+n])&&(y=e[1+n]),(e.length===2+n&&!C(e[1+n])||e.length===3+n)&&(_=e[e.length-1]||u);const{initialData:g,shallow:T,onSuccess:b=j,onError:t=j,immediate:l,resetOnExecute:c=!1}=_,f=R(),h=(T?R:P)(g),a=P(!1),s=P(!1),d=P(!1),i=R();let m=new AbortController;const w=r=>{a.value||!s.value||(m.abort(r),m=new AbortController,d.value=!0,s.value=!1,a.value=!1)},B=r=>{s.value=r,a.value=!r},W=()=>{c&&(h.value=g)},x=()=>new Promise((r,N)=>{ae(a).toBe(!0).then(()=>i.value?N(i.value):r(O))}),S={then:(...r)=>x().then(...r),catch:(...r)=>x().catch(...r)};let E=0;const D=(r=o,N={})=>{i.value=void 0;const F=typeof r=="string"?r:o!=null?o:N.url;if(F===void 0)return i.value=new U(U.ERR_INVALID_URL),a.value=!0,S;W(),_.abortPrevious!==!1&&w(),B(!0),E+=1;const q=E;return d.value=!1,y(F,{...p,...typeof r=="object"?r:N,signal:m.signal}).then(v=>{if(d.value)return;f.value=v;const I=v.data;h.value=I,b(I)}).catch(v=>{i.value=v,t(v)}).finally(()=>{var v;(v=_.onFinish)==null||v.call(_),q===E&&B(!1)}),S};l&&o&&D();const O={response:f,data:h,error:i,isFinished:a,isLoading:s,cancel:w,isAborted:d,isCanceled:d,abort:w,execute:D};return{...O,...S}}export{Te as _,Be as u};
