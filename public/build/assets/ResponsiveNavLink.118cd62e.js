import{o as s,d as a,a as c,_ as S,c as p,w as r,m as v,p as j,Q as z,r as k,h as B,u as t,J as M,e as o,b as i,t as u,s as h,f as x,F as N,j as C,n as w}from"./app.8ff0f107.js";import{_}from"./SecondaryButton.5221202e.js";import{a as b,_ as F}from"./DateTranslation.68228c64.js";import"./dayjs.min.61a7718e.js";function te(n,e){return s(),a("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true","data-slot":"icon"},[c("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"})])}const R={};function T(n,e){return s(),p(j,{"enter-from-class":"opacity-0","enter-to-class":"opacity-100 ",appear:"","enter-active-class":"transition duration-300 ease-in-out ","leave-active-class":"transition duration-300 ease-in-out ","leave-from-class":"opacity-100 ","leave-to-class":"opacity-0 ",mode:"out-in"},{default:r(()=>[v(n.$slots,"default")]),_:3})}const V=S(R,[["render",T]]),Y={key:0,class:"fixed bottom-0 z-40 flex justify-between w-full max-md:text-xs",id:"SysMessage"},A={key:0,class:"flex w-full px-6 py-4 bg-sky-500"},J={class:"flex items-center justify-between w-full mt-3 space-x-4"},L={class:"mr-16 font-bold text-sky-50"},q={key:1,class:"flex w-full px-6 py-4 bg-yellow-300"},D={class:"flex flex-col items-center justify-between w-full mt-3 space-x-4 gap-y-2 md:flex-row"},E={class:"mr-16 font-bold text-gray-700"},H={key:2,class:"flex w-full px-6 py-4 bg-rose-500"},I={class:"flex items-center justify-between w-full mt-3 space-x-4"},K={class:"mr-16 font-bold text-rose-50"},O={key:3,class:"flex w-full px-6 py-4 bg-emerald-500"},Q={class:"flex items-center justify-between w-full mt-3 space-x-4"},G={class:"mr-16 font-bold text-emerald-50"},se={__name:"SystemMessage",setup(n){var y;const e=(y=z().props.flash)==null?void 0:y.message,l=k(!0),d=k(null);return B(()=>{e&&(d.value=document.querySelector("#SysMessage").offsetHeight),(e==null?void 0:e.type)==="success"&&setTimeout(()=>{l.value=!1},2e4)}),(m,f)=>(s(),a(N,null,[t(e)&&l.value?(s(),a("div",{key:0,class:"m-0",style:M(`height: ${d.value}px;`)},null,4)):o("",!0),i(V,null,{default:r(()=>[t(e)&&l.value?(s(),a("div",Y,[t(e).type==="info"?(s(),a("div",A,[c("div",J,[c("p",L,u(t(e).body),1),t(e).action?(s(),p(t(h),{key:0,href:t(e).action.url},{default:r(()=>[i(_,{size:"sm"},{default:r(()=>[x(u(m.$t(t(e).action.text)),1)]),_:1})]),_:1},8,["href"])):o("",!0),t(e).closeable&&!t(e).action?(s(),a("button",{key:1,onClick:f[0]||(f[0]=g=>l.value=!1),class:"absolute top-1 rtl:-left-2 ltr:-right-0"},[i(t(b),{class:"w-6 h-6 text-white"})])):o("",!0)])])):o("",!0),t(e).type==="warning"?(s(),a("div",q,[c("div",D,[c("p",E,u(m.$t(t(e).body)),1),t(e).action?(s(),p(t(h),{key:0,href:t(e).action.url,class:"px-[67px]"},{default:r(()=>[i(_,{size:"sm",class:"max-sm:!text-[9px]"},{default:r(()=>[x(u(m.$t(t(e).action.text)),1)]),_:1})]),_:1},8,["href"])):o("",!0),t(e).closeable&&!t(e).action?(s(),a("button",{key:1,onClick:f[1]||(f[1]=g=>l.value=!1),class:"absolute top-1 rtl:-left-2 ltr:-right-2"},[i(t(b),{class:"w-6 h-6 text-stone-600"})])):o("",!0)])])):o("",!0),t(e).type==="danger"?(s(),a("div",H,[c("div",I,[c("p",K,u(m.$t(t(e).body)),1),t(e).action?(s(),p(t(h),{key:0,href:t(e).action.url},{default:r(()=>[i(_,{class:"max-sm:!text-[9px]",size:"sm"},{default:r(()=>[x(u(m.$t(t(e).action.text)),1)]),_:1})]),_:1},8,["href"])):o("",!0),t(e).closeable&&!t(e).action?(s(),a("button",{key:1,onClick:f[2]||(f[2]=g=>l.value=!1),class:"absolute top-1 rtl:-left-2 ltr:-right-0"},[i(t(b),{class:"w-6 h-6 text-white"})])):o("",!0)])])):o("",!0),t(e).type==="success"?(s(),a("div",O,[c("div",Q,[c("p",G,u(t(e).body),1),t(e).action?(s(),p(t(h),{key:0,href:t(e).action.url},{default:r(()=>[i(_,{class:"max-sm:!text-[9px]",size:"sm"},{default:r(()=>[x(u(m.$t(t(e).action.text)),1)]),_:1})]),_:1},8,["href"])):o("",!0),t(e).closeable&&!t(e).action?(s(),a("button",{key:1,onClick:f[3]||(f[3]=g=>l.value=!1),class:"absolute top-1 rtl:-left-2 ltr:-right-0"},[i(t(b),{class:"w-6 h-6 text-white"})])):o("",!0)])])):o("",!0)])):o("",!0)]),_:1})],64))}},P={class:"h-10 flex justify-center"},U={class:"text-white text-xs font-regular"},ae={__name:"CopyrightClaim",setup(n){return(e,l)=>(s(),a("div",P,[c("p",U,[x(u(e.$t("Copyright"))+" \xA9 ",1),i(F,{format:"YYYY"}),x(" KJORA. "+u(e.$t("All Rights Reserved"))+". ",1)])]))}},oe={__name:"NavLink",props:{href:String,active:Boolean},setup(n){const e=n,l=C(()=>e.active?"inline-flex items-center gap-2 px-1 pt-1  before:absolute before:h-1 before:bg-primary relative before:rounded-full before:bottom-[0px] before:w-[60%]  text-sm font-medium leading-5 text-white focus:outline-none  transition uppercase":"inline-flex items-center gap-2 px-1 pt-1 text-sm font-medium leading-5 hover:text-stone-400 text-white focus:outline-none focus:text-gray-700 transition uppercase");return(d,y)=>(s(),p(t(h),{href:n.href,class:w([l.value,"py-2"])},{default:r(()=>[v(d.$slots,"default")]),_:3},8,["href","class"]))}},$="block w-full py-2 pl-3 pr-4 text-base font-medium text-white uppercase transition rtl:border-r-4 ltr:border-l-4 hover:bg-gray-50 focus:outline-none focus:text-primary hover:text-primary",le={__name:"ResponsiveNavLink",props:{active:Boolean,href:String,as:String},setup(n){const e=n,l=C(()=>e.active?"border-primary bg-transparent focus:bg-transparent"+$:"border-transparent "+$);return(d,y)=>(s(),a("div",null,[n.as=="button"?(s(),a("button",{key:0,class:w(l.value)},[v(d.$slots,"default")],2)):(s(),p(t(h),{key:1,href:n.href,class:w(["flex items-center gap-2",l.value])},{default:r(()=>[v(d.$slots,"default")]),_:3},8,["href","class"]))]))}};export{V as F,oe as _,le as a,ae as b,se as c,te as r};
