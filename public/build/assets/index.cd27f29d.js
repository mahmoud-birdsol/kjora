import{af as Ee,j as c,ab as Ke,ag as X,N as ze,a9 as We,H as Ue,aj as q,r as J,ar as Ye,y as Z,S as F,h as _e,U as Xe,o as f,d as x,e as m,F as G,n as h,u as t,m as D,a as N,c as S,w as L,A as j,W as Q,b as qe,I as Je,an as Ze,t as K,J as Ge,ah as ge,a4 as be}from"./app.8ff0f107.js";import{i as xe,U as te,u as Qe,o as et,p as tt,V as ot,v as at,q as nt,r as st,s as rt,E as $,c as it}from"./index.77b13ae5.js";import{D as lt,E as we,b as ut,u as dt,d as ee,a as Se}from"./index.412eb292.js";import{u as ct,_ as pt,w as ft}from"./plugin-vue_export-helper.c628866e.js";import{u as vt,a as mt}from"./use-form-common-props.317c2149.js";import{d as Ce}from"./error.7e8331f1.js";const ht=()=>Ee&&/firefox/i.test(window.navigator.userAgent),yt=a=>a,gt=["class","style"],bt=/^on[A-Z]/,xt=(a={})=>{const{excludeListeners:p=!1,excludeKeys:s}=a,o=c(()=>((s==null?void 0:s.value)||[]).concat(gt)),r=Ke();return r?c(()=>{var i;return lt(Object.entries((i=r.proxy)==null?void 0:i.$attrs).filter(([l])=>!o.value.includes(l)&&!(p&&bt.test(l))))}):c(()=>({}))};function wt(a){let p;function s(){if(a.value==null)return;const{selectionStart:r,selectionEnd:i,value:l}=a.value;if(r==null||i==null)return;const y=l.slice(0,Math.max(0,r)),d=l.slice(Math.max(0,i));p={selectionStart:r,selectionEnd:i,value:l,beforeTxt:y,afterTxt:d}}function o(){if(a.value==null||p==null)return;const{value:r}=a.value,{beforeTxt:i,afterTxt:l,selectionStart:y}=p;if(i==null||l==null||y==null)return;let d=r.length;if(r.endsWith(l))d=r.length-l.length;else if(r.startsWith(i))d=i.length;else{const b=i[y-1],C=r.indexOf(b,y-1);C!==-1&&(d=C+1)}a.value.setSelectionRange(d,d)}return[s,o]}let g;const St=`
  height:0 !important;
  visibility:hidden !important;
  ${ht()?"":"overflow:hidden !important;"}
  position:absolute !important;
  z-index:-1000 !important;
  top:0 !important;
  right:0 !important;
`,Ct=["letter-spacing","line-height","padding-top","padding-bottom","font-family","font-weight","font-size","text-rendering","text-transform","width","text-indent","padding-left","padding-right","border-width","box-sizing"];function It(a){const p=window.getComputedStyle(a),s=p.getPropertyValue("box-sizing"),o=Number.parseFloat(p.getPropertyValue("padding-bottom"))+Number.parseFloat(p.getPropertyValue("padding-top")),r=Number.parseFloat(p.getPropertyValue("border-bottom-width"))+Number.parseFloat(p.getPropertyValue("border-top-width"));return{contextStyle:Ct.map(l=>`${l}:${p.getPropertyValue(l)}`).join(";"),paddingSize:o,borderSize:r,boxSizing:s}}function Ie(a,p=1,s){var o;g||(g=document.createElement("textarea"),document.body.appendChild(g));const{paddingSize:r,borderSize:i,boxSizing:l,contextStyle:y}=It(a);g.setAttribute("style",`${y};${St}`),g.value=a.value||a.placeholder||"";let d=g.scrollHeight;const b={};l==="border-box"?d=d+i:l==="content-box"&&(d=d-r),g.value="";const C=g.scrollHeight-r;if(we(p)){let v=C*p;l==="border-box"&&(v=v+r+i),d=Math.max(v,d),b.minHeight=`${v}px`}if(we(s)){let v=C*s;l==="border-box"&&(v=v+r+i),d=Math.min(v,d)}return b.height=`${d}px`,(o=g.parentNode)==null||o.removeChild(g),g=void 0,b}const Et=ut({id:{type:String,default:void 0},size:dt,disabled:Boolean,modelValue:{type:ee([String,Number,Object]),default:""},maxlength:{type:[String,Number]},minlength:{type:[String,Number]},type:{type:String,default:"text"},resize:{type:String,values:["none","both","horizontal","vertical"]},autosize:{type:ee([Boolean,Object]),default:!1},autocomplete:{type:String,default:"off"},formatter:{type:Function},parser:{type:Function},placeholder:{type:String},form:{type:String},readonly:Boolean,clearable:Boolean,showPassword:Boolean,showWordLimit:Boolean,suffixIcon:{type:xe},prefixIcon:{type:xe},containerRole:{type:String,default:void 0},tabindex:{type:[String,Number],default:0},validateEvent:{type:Boolean,default:!0},inputStyle:{type:ee([Object,Array,String]),default:()=>yt({})},autofocus:Boolean,rows:{type:Number,default:2},...ct(["ariaLabel"])}),zt={[te]:a=>X(a),input:a=>X(a),change:a=>X(a),focus:a=>a instanceof FocusEvent,blur:a=>a instanceof FocusEvent,clear:()=>!0,mouseleave:a=>a instanceof MouseEvent,mouseenter:a=>a instanceof MouseEvent,keydown:a=>a instanceof Event,compositionstart:a=>a instanceof CompositionEvent,compositionupdate:a=>a instanceof CompositionEvent,compositionend:a=>a instanceof CompositionEvent},Pt=ze({name:"ElInput",inheritAttrs:!1}),kt=ze({...Pt,props:Et,emits:zt,setup(a,{expose:p,emit:s}){const o=a,r=We(),i=Ue(),l=c(()=>{const e={};return o.containerRole==="combobox"&&(e["aria-haspopup"]=r["aria-haspopup"],e["aria-owns"]=r["aria-owns"],e["aria-expanded"]=r["aria-expanded"]),e}),y=c(()=>[o.type==="textarea"?ae.b():n.b(),n.m(Pe.value),n.is("disabled",E.value),n.is("exceed",Re.value),{[n.b("group")]:i.prepend||i.append,[n.m("prefix")]:i.prefix||o.prefixIcon,[n.m("suffix")]:i.suffix||o.suffixIcon||o.clearable||o.showPassword,[n.bm("suffix","password-clear")]:O.value&&U.value,[n.b("hidden")]:o.type==="hidden"},r.class]),d=c(()=>[n.e("wrapper"),n.is("focus",H.value)]),b=xt({excludeKeys:c(()=>Object.keys(l.value))}),{form:C,formItem:v}=Qe(),{inputId:oe}=et(o,{formItemContext:v}),Pe=vt(),E=mt(),n=Se("input"),ae=Se("textarea"),A=q(),w=q(),W=J(!1),B=J(!1),ne=J(),M=q(o.inputStyle),z=c(()=>A.value||w.value),{wrapperRef:ke,isFocused:H,handleFocus:Fe,handleBlur:Ne}=tt(z,{beforeFocus(){return E.value},afterBlur(){var e;o.validateEvent&&((e=v==null?void 0:v.validate)==null||e.call(v,"blur").catch(u=>Ce()))}}),se=c(()=>{var e;return(e=C==null?void 0:C.statusIcon)!=null?e:!1}),T=c(()=>(v==null?void 0:v.validateState)||""),re=c(()=>T.value&&ot[T.value]),Te=c(()=>B.value?at:nt),Ve=c(()=>[r.style]),ie=c(()=>[o.inputStyle,M.value,{resize:o.resize}]),I=c(()=>st(o.modelValue)?"":String(o.modelValue)),O=c(()=>o.clearable&&!E.value&&!o.readonly&&!!I.value&&(H.value||W.value)),U=c(()=>o.showPassword&&!E.value&&!!I.value&&(!!I.value||H.value)),P=c(()=>o.showWordLimit&&!!o.maxlength&&(o.type==="text"||o.type==="textarea")&&!E.value&&!o.readonly&&!o.showPassword),Y=c(()=>I.value.length),Re=c(()=>!!P.value&&Y.value>Number(o.maxlength)),Le=c(()=>!!i.suffix||!!o.suffixIcon||O.value||o.showPassword||P.value||!!T.value&&se.value),[$e,Ae]=wt(A);Ye(w,e=>{if(Be(),!P.value||o.resize!=="both")return;const u=e[0],{width:k}=u.contentRect;ne.value={right:`calc(100% - ${k+15+6}px)`}});const V=()=>{const{type:e,autosize:u}=o;if(!(!Ee||e!=="textarea"||!w.value))if(u){const k=ge(u)?u.minRows:void 0,he=ge(u)?u.maxRows:void 0,ye=Ie(w.value,k,he);M.value={overflowY:"hidden",...ye},F(()=>{w.value.offsetHeight,M.value=ye})}else M.value={minHeight:Ie(w.value).minHeight}},Be=(e=>{let u=!1;return()=>{var k;if(u||!o.autosize)return;((k=w.value)==null?void 0:k.offsetParent)===null||(e(),u=!0)}})(V),R=()=>{const e=z.value,u=o.formatter?o.formatter(I.value):I.value;!e||e.value===u||(e.value=u)},_=async e=>{$e();let{value:u}=e.target;if(o.formatter&&(u=o.parser?o.parser(u):u),!ue.value){if(u===I.value){R();return}s(te,u),s("input",u),await F(),R(),Ae()}},le=e=>{s("change",e.target.value)},{isComposing:ue,handleCompositionStart:de,handleCompositionUpdate:ce,handleCompositionEnd:pe}=rt({emit:s,afterComposition:_}),Me=()=>{B.value=!B.value,fe()},fe=async()=>{var e;await F(),(e=z.value)==null||e.focus()},He=()=>{var e;return(e=z.value)==null?void 0:e.blur()},Oe=e=>{W.value=!1,s("mouseleave",e)},De=e=>{W.value=!0,s("mouseenter",e)},ve=e=>{s("keydown",e)},je=()=>{var e;(e=z.value)==null||e.select()},me=()=>{s(te,""),s("change",""),s("clear"),s("input","")};return Z(()=>o.modelValue,()=>{var e;F(()=>V()),o.validateEvent&&((e=v==null?void 0:v.validate)==null||e.call(v,"change").catch(u=>Ce()))}),Z(I,()=>R()),Z(()=>o.type,async()=>{await F(),R(),V()}),_e(()=>{!o.formatter&&o.parser,R(),F(V)}),p({input:A,textarea:w,ref:z,textareaStyle:ie,autosize:Xe(o,"autosize"),isComposing:ue,focus:fe,blur:He,select:je,clear:me,resizeTextarea:V}),(e,u)=>(f(),x("div",Q(t(l),{class:[t(y),{[t(n).bm("group","append")]:e.$slots.append,[t(n).bm("group","prepend")]:e.$slots.prepend}],style:t(Ve),role:e.containerRole,onMouseenter:De,onMouseleave:Oe}),[m(" input "),e.type!=="textarea"?(f(),x(G,{key:0},[m(" prepend slot "),e.$slots.prepend?(f(),x("div",{key:0,class:h(t(n).be("group","prepend"))},[D(e.$slots,"prepend")],2)):m("v-if",!0),N("div",{ref_key:"wrapperRef",ref:ke,class:h(t(d))},[m(" prefix slot "),e.$slots.prefix||e.prefixIcon?(f(),x("span",{key:0,class:h(t(n).e("prefix"))},[N("span",{class:h(t(n).e("prefix-inner"))},[D(e.$slots,"prefix"),e.prefixIcon?(f(),S(t($),{key:0,class:h(t(n).e("icon"))},{default:L(()=>[(f(),S(j(e.prefixIcon)))]),_:1},8,["class"])):m("v-if",!0)],2)],2)):m("v-if",!0),N("input",Q({id:t(oe),ref_key:"input",ref:A,class:t(n).e("inner")},t(b),{minlength:e.minlength,maxlength:e.maxlength,type:e.showPassword?B.value?"text":"password":e.type,disabled:t(E),readonly:e.readonly,autocomplete:e.autocomplete,tabindex:e.tabindex,"aria-label":e.ariaLabel,placeholder:e.placeholder,style:e.inputStyle,form:e.form,autofocus:e.autofocus,onCompositionstart:t(de),onCompositionupdate:t(ce),onCompositionend:t(pe),onInput:_,onChange:le,onKeydown:ve}),null,16,["id","minlength","maxlength","type","disabled","readonly","autocomplete","tabindex","aria-label","placeholder","form","autofocus","onCompositionstart","onCompositionupdate","onCompositionend"]),m(" suffix slot "),t(Le)?(f(),x("span",{key:1,class:h(t(n).e("suffix"))},[N("span",{class:h(t(n).e("suffix-inner"))},[!t(O)||!t(U)||!t(P)?(f(),x(G,{key:0},[D(e.$slots,"suffix"),e.suffixIcon?(f(),S(t($),{key:0,class:h(t(n).e("icon"))},{default:L(()=>[(f(),S(j(e.suffixIcon)))]),_:1},8,["class"])):m("v-if",!0)],64)):m("v-if",!0),t(O)?(f(),S(t($),{key:1,class:h([t(n).e("icon"),t(n).e("clear")]),onMousedown:Je(t(Ze),["prevent"]),onClick:me},{default:L(()=>[qe(t(it))]),_:1},8,["class","onMousedown"])):m("v-if",!0),t(U)?(f(),S(t($),{key:2,class:h([t(n).e("icon"),t(n).e("password")]),onClick:Me},{default:L(()=>[(f(),S(j(t(Te))))]),_:1},8,["class"])):m("v-if",!0),t(P)?(f(),x("span",{key:3,class:h(t(n).e("count"))},[N("span",{class:h(t(n).e("count-inner"))},K(t(Y))+" / "+K(e.maxlength),3)],2)):m("v-if",!0),t(T)&&t(re)&&t(se)?(f(),S(t($),{key:4,class:h([t(n).e("icon"),t(n).e("validateIcon"),t(n).is("loading",t(T)==="validating")])},{default:L(()=>[(f(),S(j(t(re))))]),_:1},8,["class"])):m("v-if",!0)],2)],2)):m("v-if",!0)],2),m(" append slot "),e.$slots.append?(f(),x("div",{key:1,class:h(t(n).be("group","append"))},[D(e.$slots,"append")],2)):m("v-if",!0)],64)):(f(),x(G,{key:1},[m(" textarea "),N("textarea",Q({id:t(oe),ref_key:"textarea",ref:w,class:[t(ae).e("inner"),t(n).is("focus",t(H))]},t(b),{minlength:e.minlength,maxlength:e.maxlength,tabindex:e.tabindex,disabled:t(E),readonly:e.readonly,autocomplete:e.autocomplete,style:t(ie),"aria-label":e.ariaLabel,placeholder:e.placeholder,form:e.form,autofocus:e.autofocus,rows:e.rows,onCompositionstart:t(de),onCompositionupdate:t(ce),onCompositionend:t(pe),onInput:_,onFocus:t(Fe),onBlur:t(Ne),onChange:le,onKeydown:ve}),null,16,["id","minlength","maxlength","tabindex","disabled","readonly","autocomplete","aria-label","placeholder","form","autofocus","rows","onCompositionstart","onCompositionupdate","onCompositionend","onFocus","onBlur"]),t(P)?(f(),x("span",{key:0,style:Ge(ne.value),class:h(t(n).e("count"))},K(t(Y))+" / "+K(e.maxlength),7)):m("v-if",!0)],64))],16,["role"]))}});var Ft=pt(kt,[["__file","input.vue"]]);const Ht=ft(Ft),Nt=100,Tt=600,Ot={beforeMount(a,p){const s=p.value,{interval:o=Nt,delay:r=Tt}=be(s)?{}:s;let i,l;const y=()=>be(s)?s():s.handler(),d=()=>{l&&(clearTimeout(l),l=void 0),i&&(clearInterval(i),i=void 0)};a.addEventListener("mousedown",b=>{b.button===0&&(d(),y(),document.addEventListener("mouseup",()=>d(),{once:!0}),l=setTimeout(()=>{i=setInterval(()=>{y()},o)},r))})}};export{Ht as E,Ot as v};
