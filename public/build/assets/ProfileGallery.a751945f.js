import{_ as Z}from"./RatingChart.f70fd005.js";import{o as r,d as u,b as d,u as p,r as c,Q as M,c as V,w as k,a as o,f as A,t as S,q as E,a5 as D,I as P,F as j,g as G,e as v,v as ee,s as le,C as te}from"./app.8ff0f107.js";import"./base.1b1bd1ad.js";import{v as se}from"./loading.0484db5f.js";import{_ as ae}from"./Modal.b3ff11aa.js";import{_ as oe}from"./PrimaryButton.11a51cad.js";import{F as Q}from"./ResponsiveNavLink.118cd62e.js";import{_ as re}from"./InputLabel.9cf3d0c8.js";import{_ as ie}from"./CropIcon.7fde5f5f.js";import{C as ne}from"./Crop.ae2eb42b.js";import{_ as ue}from"./Title.f9acf21c.js";import{r as H}from"./PlusCircleIcon.76342808.js";import{r as de}from"./XMarkIcon.4621726c.js";import{_ as ce}from"./FixedActionBtn.dec50423.js";import{_ as fe}from"./ConfirmationModal.2d697eda.js";import{r as me}from"./PlayIcon.11e5e915.js";import{r as pe}from"./EyeIcon.3eb2c4df.js";const ve={class:"text-xl text-center text-white capitalize overflow-hidden max-sm:pb-20"},il={__name:"PerformanceTab",props:["playerRating"],setup(h){const C=h,F=C.playerRating.map(s=>s.value),b=C.playerRating.map(s=>s.ratingCategory);return(s,g)=>(r(),u("div",ve,[d(Z,{data:p(F),labels:p(b)},null,8,["data","labels"])]))}},he={class:"flex flex-col min-h-[500px] justify-between p-6 pt-0"},_e={class:"flex items-center flex-grow"},ge=["placeholder"],xe={class:"flex flex-col items-center h-full gap-2 py-8"},be={class:"max-w-[300px] sm:px-20 w-full"},ye={class:"flex items-center justify-center mb-6"},we=["disabled"],$e={class:"relative overflow-auto hideScrollBar max-h-80"},ke={class:"relative grid grid-cols-3 gap-2"},Ce={key:0,class:"relative"},Fe=["src"],Se=["src"],We=["onClick"],Ie={class:"flex flex-col items-start justify-center h-full p-1 opacity-100"},Ne=["onClick"],je={class:"flex flex-col items-start justify-center h-full p-1 opacity-100"},qe={key:0,class:"absolute inset-0 z-20 grid w-full h-full p-4 bg-stone-400/50 place-content-center"},Ue={key:0,class:"mb-2 text-sm text-center text-red-500"},Be={key:1,class:"mb-2 text-sm text-center text-red-500 justify-self-end"},Pe={__name:"UploadGalleryFile",props:{modelValue:{required:!1,type:String,default:null},shouldUpload:{require:!1,type:Boolean,default:!1},currentImageUrl:{required:!1,type:String,default:null},modelName:{required:!1,type:String},modelId:{required:!1,type:Number},collectionName:{required:!1,type:String},show:{type:Boolean,default:!1},maxWidth:{type:String,default:"lg"},closeable:{type:Boolean,default:!0},position:{required:!1,type:String,default:"center"}},emits:["close","update:modelValue","reload"],setup(h,{emit:C}){const F=C,b=c(!1),s=c([]),g=c(null),y=c(!1),w=c(!1),f=c(""),i=c([]),x=c(!1),I=c(0),$=c(!1),l=c(M().props.maximumUploadNumberOfFiles);let W=null;const q=()=>{g.value.value=null,$.value=!1,g.value.click()},U=()=>{if(!g.value.files.length)return;let e=Array.from(g.value.files).map(a=>({file:a,id:_.uniqueId("f")}));e=B(e),e==null||e.forEach(({file:a,id:n},t)=>{const m=URL.createObjectURL(a);s.value.push({file:a,url:m,name:a.name,type:a.type,id:n}),b.value=!0})};function B(e){if(e.length+s.value.length>l.value){let n=l.value-s.value.length;if(n<=0)return;if(n)return e=e.slice(0,n)}return e}const N=({file:e,url:a,id:n})=>{let t=s.value.findIndex(m=>m.id===n);s.value.splice(t,1),s.value.length===0&&(b.value=!1),i.value.id===n&&(i.value=[],x.value=!1)},J=async()=>{if(!!s.value.length)if(y.value=!0,w.value=!0,$.value=!1,W)s.value.slice(1).length>0?z(W):R();else try{W=(await axios.postForm(route("api.posts.store"),{cover:s.value[0].file,caption:f.value.trim()})).data.id,z(W)}catch(e){console.log("there is error uploading this file (cover) "+s.value[0].name),O(e,s.value[0])}};function z(e){const a=s.value.slice(1).map((n,t)=>{const{file:m,id:T}=n;if(m.type.startsWith("image")||m.type.startsWith("video"))return axios.postForm(route("api.gallery.upload",e),{gallery:m}).catch(Y=>{console.log("there is error uploading this file "+m.name),O(Y,m)})});Promise.all(a).then(()=>{R()}).catch(n=>{}).finally(()=>{y.value=!1,w.value=!1})}function O(e,a){var n,t;console.error(e),(((n=e==null?void 0:e.response)==null?void 0:n.status)===422||((t=e==null?void 0:e.response)==null?void 0:t.status)===413)&&($.value=!0,N(a),y.value=!1,w.value=!1)}function R(){L(),F("reload")}function L(e){s.value=[],y.value=!1,w.value=!1,$.value=!1,W=null,f.value="",I.value+=1,F("close")}function K(e,a,n){let t=s.value.findIndex(m=>m.id===n);s.value[t].url=a,s.value[t].file=e,i.value=[]}let X=e=>{i.value=e,x.value=!0};return(e,a)=>{const n=se;return r(),V(ae,{show:h.show,"max-width":h.maxWidth,closeable:h.closeable,position:h.position,onClose:L,key:I.value},{default:k(()=>[o("div",he,[d(ue,null,{default:k(()=>[A(S(e.$t("upload")),1)]),_:1}),o("div",null,[d(re,{value:"Caption",class:"text-primary"}),o("div",_e,[E(o("textarea",{"onUpdate:modelValue":a[0]||(a[0]=t=>f.value=t),name:"caption",id:"caption",rows:"1",placeholder:e.$t("please write caption"),class:"w-full p-2 px-4 border-none rounded-full resize-none hideScrollBar placeholder:text-neutral-400 text-stone-700 ring-1 focus:ring-primary ring-stone-400"},null,8,ge),[[D,f.value]])])]),o("div",xe,[o("div",be,[o("input",{ref_key:"fileInput",ref:g,type:"file",multiple:"",accept:"video/*,image/*",class:"hidden",onChange:U},null,544),o("div",ye,[o("button",{type:"button",disabled:w.value,class:"inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm enabled: enabled:hover:bg-black enabled:focus:outline-none enabled:focus:ring-2 enabled:focus:ring-black enabled:focus:ring-offset-2 disabled:bg-stone-500",onClick:P(q,["prevent"])},[d(p(H),{class:"w-5 h-5"})],8,we)])]),E((r(),u("div",$e,[o("div",ke,[(r(!0),u(j,null,G(s.value,(t,m)=>(r(),u(j,{key:m},[t.url.startsWith("data:image")||t.type.startsWith("image")||t.url.startsWith("data:video")||t.type.startsWith("video")?(r(),u("div",Ce,[t.url.startsWith("data:image")||t.type.startsWith("image")?(r(),u("img",{key:0,src:t.url,alt:"",class:"object-contain w-full h-full rounded-lg aspect-square"},null,8,Fe)):v("",!0),t.url.startsWith("data:video")||t.type.startsWith("video")?(r(),u("video",{key:1,src:t.url,alt:"",class:"object-cover w-full h-full rounded-lg aspect-square"},null,8,Se)):v("",!0),o("button",{onClick:P(T=>N(t),["prevent"]),class:"absolute top-0 right-0 bg-white bg-opacity-90 rounded-bl-xl"},[o("div",Ie,[d(p(de),{class:"w-5 h-5 text-stone-800"})])],8,We),t.url.startsWith("data:image")||t.type.startsWith("image")?(r(),u("button",{key:2,class:"absolute top-0 left-0 bg-white bg-opacity-90 rounded-br-xl",onClick:T=>p(X)(t)},[o("div",je,[d(ie,{class:"w-4"})])],8,Ne)):v("",!0)])):v("",!0)],64))),128)),d(Q,null,{default:k(()=>[y.value?(r(),u("div",qe)):v("",!0)]),_:1})])])),[[ee,b.value],[n,y.value]])]),o("div",null,[d(ne,{img:i.value,onCrop:K,open:x.value,"onUpdate:open":[a[1]||(a[1]=t=>x.value=t),a[2]||(a[2]=()=>x.value=!1)]},null,8,["img","open"]),s.value.length>=l.value?(r(),u("div",Ue,S(e.$t("the maximum allowed file is :maximumUploadNumberOfFiles",{maximumUploadNumberOfFiles:l.value})),1)):v("",!0),$.value?(r(),u("div",Be,S(e.$t("only videos and images with max size (84MB) are allowed")),1)):v("",!0),d(oe,{onClick:P(J,["prevent"]),disabled:w.value},{default:k(()=>[A(S(e.$t("upload")),1)]),_:1},8,["disabled"])])])]),_:1},8,["show","max-width","closeable","position"])}}},Me={key:0,class:""},Ve={class:"grid grid-cols-2 gap-4 overflow-auto max-h-[500px] sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 hideScrollBar"},ze={key:0,class:"absolute top-0 ltr:right-0 rtl:left-0 px-1 scale-90 py[0.5px] m-1 text-xs text-white rounded-full font-thin bg-black/40"},Oe=["src"],Re=["src","poster"],Le={class:"absolute inset-0 flex items-center justify-center gap-2 text-xs text-gray-100"},Te={class:"absolute flex items-center gap-2 text-xs text-gray-100 bottom-2 ltr:right-2 rtl:left-2"},Ae={class:"filter-[drop-shadow(1px_1px_1px_rgb(0_0_0/.4)]"},nl={__name:"ProfileGallery",props:{user:{required:!0},posts:null,media:null,shouldPreview:null},emits:["reload"],setup(h){const C=h,F=M().url.includes("public/player"),b=c(!1),s=M().props.auth.user,g=c(!1),y=c(null);function w(f){let i=C.posts.findIndex(x=>x.id==f);C.posts.splice(i,1),g.value=!1,te.delete(route("posts.destroy",f),{preserveState:!0,preserveScroll:!0})}return(f,i)=>{var x,I,$;return r(),u(j,null,[(x=h.posts)!=null&&x.length?(r(),u("div",Me,[o("div",Ve,[(r(!0),u(j,null,G(h.posts,(l,W)=>(r(),V(Q,{key:l.id},{default:k(()=>[d(p(le),{href:p(F)?f.route("public.posts",l.id):f.route("posts.show",l.id),class:"relative w-full h-full overflow-hidden rounded-lg aspect-square group"},{default:k(()=>{var q,U,B,N;return[l.media.length>1?(r(),u("div",ze,S(`${l.media.length} ${f.$t("files")}`),1)):v("",!0),(q=l==null?void 0:l.cover_photo)!=null&&q.mime_type.startsWith("image")?(r(),u("img",{key:1,src:(U=l==null?void 0:l.cover_photo)==null?void 0:U.original_url,alt:"",class:"object-cover w-full h-full"},null,8,Oe)):v("",!0),(B=l==null?void 0:l.cover_photo)!=null&&B.mime_type.startsWith("video")?(r(),u(j,{key:2},[o("video",{src:(N=l==null?void 0:l.cover_photo)==null?void 0:N.original_url,controls:!1,poster:l==null?void 0:l.cover_thumb_photo,class:"object-cover object-left w-full h-full max-w-full mx-auto rounded-lg"},null,8,Re),o("div",Le,[d(p(me),{class:"h-10 filter-[drop-shadow(1px_1px_1px_rgb(0_0_0/.4)]"})])],64)):v("",!0),o("div",Te,[o("span",Ae,S(l.views_count),1),d(p(pe),{class:"h-5 w-5 filter-[drop-shadow(1px_1px_1px_rgb(0_0_0/.4)]"})])]}),_:2},1032,["href"])]),_:2},1024))),128))])])):v("",!0),d(fe,{show:g.value,onClose:i[0]||(i[0]=l=>g.value=!1),onDelete:i[1]||(i[1]=l=>w(y.value))},{body:k(()=>[o("span",null,S(f.$t("Are you sure you want delete this post ? ")),1)]),_:1},8,["show"]),((I=p(s))==null?void 0:I.id)===(($=h.user)==null?void 0:$.id)&&!p(F)?(r(),V(ce,{key:1,onClick:i[2]||(i[2]=l=>b.value=!0)},{default:k(()=>[d(p(H),{class:"w-5 text-white"})]),_:1})):v("",!0),d(Pe,{show:b.value,onClose:i[3]||(i[3]=l=>b.value=!1),onReload:i[4]||(i[4]=l=>f.$emit("reload")),"should-upload":!0},null,8,["show"])],64)}}};export{il as _,nl as a};
