import{M as G,az as S,h as H,r as c,Q as f,j as le,k as J,o as _,c as q,b as t,w as i,q as j,a as e,v as B,u as l,f as p,t as u,d as b,e as P,n as T,I as oe,p as ie,K as ne,m as U,T as re,y as O,F as ue,Z as ce}from"./app.8ff0f107.js";import{_ as de}from"./AppLayout.ac3aab9c.js";import{_ as X}from"./PrimaryButton.11a51cad.js";import{_ as me}from"./RichSelectInput.2cc41687.js";import{_ as V}from"./InputError.f29c6013.js";import{_ as fe}from"./InputLabel.9cf3d0c8.js";import{C as E}from"./Card.79095136.js";import{_ as Q}from"./CardContent.953c4953.js";import{F as pe}from"./ResponsiveNavLink.118cd62e.js";import{C as _e}from"./Crop.ae2eb42b.js";import{_ as ve}from"./CropIcon.7fde5f5f.js";import{_ as ge}from"./Title.f9acf21c.js";import{r as ye}from"./XMarkIcon.4621726c.js";import{r as he}from"./CheckIcon.7c9aeea7.js";import{a as we}from"./DateTranslation.68228c64.js";import{_ as W}from"./UploadImageField.b9566f75.js";import{_ as be}from"./SuccessMessageModal.b452fe2d.js";import"./dayjs.min.61a7718e.js";import"./Avatar.vue_vue_type_style_index_0_lang.13aa623b.js";import"./StarIcon.5dbdfceb.js";import"./MapPinIcon.afa94ea1.js";import"./SecondaryButton.5221202e.js";import"./Modal.b3ff11aa.js";import"./InvitationPlayerCard.1c9614ad.js";import"./index.1938c188.js";/* empty css                                                  */import"./index.f405b57e.js";import"./base.1b1bd1ad.js";import"./index.412eb292.js";import"./loading.0484db5f.js";/* empty css                        */import"./floating-ui.vue.esm.b8000c53.js";import"./error.7e8331f1.js";import"./scroll.2986c3c8.js";import"./debounce.db0f0bcf.js";import"./PlayIcon.11e5e915.js";import"./PlusCircleIcon.76342808.js";const xe={prefix:"fas",iconName:"passport",icon:[448,512,[],"f5ab","M0 64C0 28.7 28.7 0 64 0L384 0c35.3 0 64 28.7 64 64l0 384c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 64zM183 278.8c-27.9-13.2-48.4-39.4-53.7-70.8l39.1 0c1.6 30.4 7.7 53.8 14.6 70.8zm41.3 9.2l-.3 0-.3 0c-2.4-3.5-5.7-8.9-9.1-16.5c-6-13.6-12.4-34.3-14.2-63.5l47.1 0c-1.8 29.2-8.1 49.9-14.2 63.5c-3.4 7.6-6.7 13-9.1 16.5zm40.7-9.2c6.8-17.1 12.9-40.4 14.6-70.8l39.1 0c-5.3 31.4-25.8 57.6-53.7 70.8zM279.6 176c-1.6-30.4-7.7-53.8-14.6-70.8c27.9 13.2 48.4 39.4 53.7 70.8l-39.1 0zM223.7 96l.3 0 .3 0c2.4 3.5 5.7 8.9 9.1 16.5c6 13.6 12.4 34.3 14.2 63.5l-47.1 0c1.8-29.2 8.1-49.9 14.2-63.5c3.4-7.6 6.7-13 9.1-16.5zM183 105.2c-6.8 17.1-12.9 40.4-14.6 70.8l-39.1 0c5.3-31.4 25.8-57.6 53.7-70.8zM352 192A128 128 0 1 0 96 192a128 128 0 1 0 256 0zM112 384c-8.8 0-16 7.2-16 16s7.2 16 16 16l224 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-224 0z"]},$e={prefix:"fas",iconName:"address-card",icon:[576,512,[62140,"contact-card","vcard"],"f2bb","M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm80 256l64 0c44.2 0 80 35.8 80 80c0 8.8-7.2 16-16 16L80 384c-8.8 0-16-7.2-16-16c0-44.2 35.8-80 80-80zm-32-96a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zm256-32l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"]},ee={prefix:"fas",iconName:"camera",icon:[512,512,[62258,"camera-alt"],"f030","M149.1 64.8L138.7 96 64 96C28.7 96 0 124.7 0 160L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64l-74.7 0L362.9 64.8C356.4 45.2 338.1 32 317.4 32L194.6 32c-20.7 0-39 13.2-45.5 32.8zM256 192a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"]},ke={prefix:"fas",iconName:"spinner",icon:[512,512,[],"f110","M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"]},Ce={class:"fixed inset-0 grid max-w-xl mx-auto transition-all transform place-items-center"},Me={class:"flex flex-col min-h-[500px] justify-between p-6 bg-white rounded-lg shadow-xl mt-2 mx-2 max-sm:min-w-[90%]"},ze={class:"flex justify-end"},Ie={class:"flex items-center justify-center w-full"},Ve={class:"relative grid w-full grid-cols-1 gap-4 my-8"},je=["width","height"],Be={key:0,class:"sm:min-w-[450px] sm:min-h-[337.5px] max-sm:aspect-square rounded border border-gray-500 flex justify-center items-center p-2"},Se={class:"text-xs font-light text-gray-500"},Fe={key:1,class:"sm:min-w-[450px] w-[80%] mx-auto sm:min-h-[337.5px] max-sm:aspect-square rounded border border-gray-500 flex justify-center items-center"},Le=["width","height"],Pe={class:"flex justify-center"},Te={__name:"UploadSelfieModal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0},modelValue:{required:!1,default:null}},emits:["close","update:modelValue"],setup(h,{emit:v}){const x=h;G(()=>{S.add(ee),S.add(ke)}),H(()=>{x.modelValue&&(D.value="/"+x.modelValue)});const I=v,m=c(null),$=c(null),D=c(null),o=c(null),k=c(!1),M=c(!1),C=c(!1),g={width:450,height:337.5},N=f().props.auth.user,z=c(null),a=le(()=>{var d;return(d=$.value)==null?void 0:d.getContext("2d")}),s=()=>{n(),k.value=!1,M.value=!1,C.value=!1,I("close")},y=()=>{const d=window.constraints={audio:!1,video:!0};k.value=!0,M.value=!0,C.value=!1,navigator.mediaDevices.getUserMedia(d).then(r=>{m.value.srcObject=r,M.value=!1}).catch(r=>{console.error(r),alert("May be the browser didn't support or there is some errors.")})};function n(){m.value&&m.value.srcObject&&m.value.srcObject.getVideoTracks().forEach(d=>{d.stop()})}const te=()=>{a.value.drawImage(m.value,0,0,g.width,g.height),n(),z.value=document.getElementById("photoTaken").toDataURL("image/jpeg").replace("image/jpeg","image/octet-stream"),C.value=!0,k.value=!1},F=c(!1),R=c(null);function se(d,r,A){z.value=r;const w=new Image;w.onload=function(){a.value.drawImage(w,0,0,g.width,g.height)},w.src=r}let K=d=>{R.value={name:`${N.name}_selfie_image`,url:z.value},F.value=!0};const ae=()=>{I("update:modelValue",z),s()};return(d,r)=>{const A=J("font-awesome-icon");return _(),q(ne,{to:"body"},[t(pe,null,{default:i(()=>[j(e("div",{class:"fixed inset-0 transition-all duration-300 transform cursor-pointer",onClick:s},r[5]||(r[5]=[e("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)]),512),[[B,h.show]])]),_:1}),t(ie,{"enter-active-class":"duration-300 ease-out","enter-from-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95","enter-to-class":"translate-y-0 opacity-100 sm:scale-100","leave-active-class":"duration-200 ease-in","leave-from-class":"translate-y-0 opacity-100 sm:scale-100","leave-to-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"},{default:i(()=>[j(e("div",Ce,[e("div",Me,[e("div",ze,[e("button",{onClick:s},[t(l(ye),{class:"w-4 h-4 text-gray-900 hover:text-gray=500"})])]),t(ge,null,{default:i(()=>[p(u(d.$t("upload")),1)]),_:1}),e("div",Ie,[e("input",{ref_key:"photoInput",ref:o,type:"file",class:"hidden",onChange:r[0]||(r[0]=(...w)=>d.updatePhotoPreview&&d.updatePhotoPreview(...w))},null,544),e("div",Ve,[j(e("video",{ref_key:"camera",ref:m,class:"-scale-x-100",width:g.width,height:g.height,autoplay:"",muted:"",playsinline:""},null,8,je),[[B,k.value&&!M.value&&!C.value]]),!k.value&&!C.value?(_(),b("div",Be,[e("p",Se,[p(u(d.$t("Click on the following link to open the camera"))+". ",1),e("a",{href:"javascript:;",class:"text-sky-500 hover:text-sky-700",onClick:y},u(d.$t("open camera")),1)])])):P("",!0),k.value&&M.value?(_(),b("div",Fe,[t(A,{icon:"spinner",spin:"",class:"w-5 h-5 text-center text-gray-500"})])):P("",!0),j(e("canvas",{id:"photoTaken",ref_key:"canvas",ref:$,class:T("max-w-full"),width:g.width,height:g.height},null,8,Le),[[B,C.value]]),C.value?(_(),b("button",{key:2,onClick:r[1]||(r[1]=(...w)=>l(K)&&l(K)(...w)),class:"absolute top-0 left-0 p-2 bg-white w-fit"},[t(ve,{class:"w-4"})])):P("",!0),t(_e,{img:R.value,onCrop:se,open:F.value,"onUpdate:open":[r[2]||(r[2]=w=>F.value=w),r[3]||(r[3]=()=>F.value=!1)]},null,8,["img","open"]),e("div",Pe,[e("button",{type:"button",class:"inline-flex items-center p-4 text-white bg-black border border-transparent rounded-full shadow-sm hover:bg-black focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2",onClick:r[4]||(r[4]=oe(w=>k.value?te():y(),["prevent"]))},[t(A,{icon:"camera",class:"w-5 h-5 text-center text-white"})])])])]),e("div",null,[t(X,{onClick:ae},{default:i(()=>[p(u(d.$t("upload")),1)]),_:1})])])],512),[[B,h.show]])]),_:1})])}}},Ue={class:"flex justify-center mb-4"},De={class:"text-white font-bold uppercase"},L={__name:"MegaButton",props:{active:{required:!1,type:Boolean,default:!1}},setup(h){return(v,x)=>(_(),b("button",{class:T(["rounded-lg p-6 w-full flex justify-center items-center min-h-[200px]",{"bg-primary":!h.active,"bg-primaryDark":h.active}]),role:"button",type:"button"},[e("div",null,[e("div",Ue,[U(v.$slots,"icon")]),e("p",De,[U(v.$slots,"default")])])],2))}},Ne={class:"text-xs text-gray-900 font-light"},Ae={class:"inline"},Y={__name:"CorrectText",setup(h){return(v,x)=>(_(),b("p",Ne,[e("span",Ae,[t(l(he),{class:"h-5 w-5 text-green-500 inline"})]),U(v.$slots,"default")]))}},qe={class:"text-xs text-gray-900 font-light"},Re={class:"inline"},Z={__name:"InCorrectText",setup(h){return(v,x)=>(_(),b("p",qe,[e("span",Re,[t(l(we),{class:"h-5 w-5 text-red-500 inline"})]),U(v.$slots,"default")]))}},Ke={class:"grid grid-cols-1 gap-4 mt-8 sm:grid-cols-2"},Oe={class:"flex flex-col justify-between h-full"},Ee={class:"min-h-[200px]"},Qe={class:"mb-4 text-lg font-bold text-gray-900"},We={class:"text-xs text-gray-500"},Ye={class:"mt-4"},Ze={class:"grid grid-cols-1 gap-4 mt-12 sm:grid-cols-2"},Ge={class:"flex flex-col justify-between h-full gap-2"},He={class:"min-h-[200px]"},Je={class:"mb-8 font-bold text-black uppercase"},Xe={class:"flex gap-4 max-md:flex-col"},et={class:"md:w-1/4"},tt=["src"],st={class:"flex flex-col items-center justify-center h-full"},at={class:"w-3/4"},lt={class:"mt-2 text-sm font-bold text-black"},ot={class:"grid grid-cols-1 gap-4 mt-10 sm:grid-cols-2"},it=["src"],nt=["src"],rt={class:"mt-4"},Qt={__name:"VerifyIdentity",props:{status:String,countries:Array},setup(h){var z;G(()=>{S.add(xe),S.add($e),S.add(ee)}),H(()=>{f().props.auth.user.identity_front_image_url!=null&&($.value=f().props.auth.user.identity_front_image_url),f().props.auth.user.identity_back_image_url!=null&&(m.value=f().props.auth.user.identity_back_image_url),f().props.auth.user.identity_selfie_image_url!=null&&(D.value=f().props.auth.user.identity_selfie_image_url)});const v=c(!1),x=c(!1),I=c(!1),m=c(null),$=c(null),D=c(null),o=re({identity_issue_country:(z=f().props.auth.user.identity_issue_country)!=null?z:"Kuwait",identity_type:f().props.auth.user.identity_type,identity_front_image:f().props.auth.user.identity_front_image_url,identity_back_image:f().props.auth.user.identity_back_image_url,identity_selfie_image:f().props.auth.user.identity_selfie_image_url});let k=f().props.auth.user.identity_status;const M=a=>{$.value=a},C=a=>{m.value=a};O(()=>o.identity_back_image,a=>{if(a!=null){const s=new FileReader;s.onload=y=>{m.value=y.target.result},s.readAsDataURL(a)}},{deep:!0}),O(()=>o.identity_front_image,a=>{if(a!=null){const s=new FileReader;s.onload=y=>{$.value=y.target.result},s.readAsDataURL(a)}},{deep:!0});const g=c(!1),N=()=>{o.post(route("identity.verification.store"),{preserveScroll:!1,preserveState:!0,onSuccess:()=>{g.value=!0}})};return(a,s)=>{const y=J("font-awesome-icon");return _(),b(ue,null,[t(l(ce),{title:"Identity Verification"}),t(de,null,{header:i(()=>[p(u(a.$t("verification")),1)]),default:i(()=>[e("div",Ke,[t(E,null,{default:i(()=>[t(Q,{title:a.$t("verify identity")},{body:i(()=>[e("div",Oe,[e("div",Ee,[e("div",null,[e("h3",Qe,u(a.$t("use a valid government-issued document")),1),e("p",We,u(a.$t("only the following documents listed below will be accepted, all other documents will be rejected"))+". ",1)]),e("div",Ye,[t(fe,{color:"primary",for:"country",value:a.$t("country of issue")},null,8,["value"]),t(me,{options:h.countries,"value-name":"name","text-name":"name","image-name":"flag",modelValue:l(o).identity_issue_country,"onUpdate:modelValue":s[0]||(s[0]=n=>l(o).identity_issue_country=n)},null,8,["options","modelValue"]),t(V,{class:"mt-2",message:l(o).errors.identity_issue_country},null,8,["message"])])]),e("div",null,[e("div",Ze,[t(L,{active:l(o).identity_type=="passport",onClick:s[1]||(s[1]=n=>l(o).identity_type="passport")},{icon:i(()=>[t(y,{icon:"passport",class:"w-12 h-auto text-center text-white"})]),default:i(()=>[p(" "+u(a.$t("passport")),1)]),_:1},8,["active"]),t(L,{active:l(o).identity_type=="national_id",onClick:s[2]||(s[2]=n=>l(o).identity_type="national_id")},{icon:i(()=>[t(y,{icon:"address-card",class:"w-12 h-auto text-center text-white"})]),default:i(()=>[p(" "+u(a.$t("government issue id")),1)]),_:1},8,["active"])]),t(V,{class:"mt-2",message:l(o).errors.identity_type},null,8,["message"])])])]),_:1},8,["title"])]),_:1}),t(E,null,{default:i(()=>[t(Q,{title:a.$t("upload identity")},{body:i(()=>[e("div",Ge,[e("div",He,[e("div",null,[e("h3",Je,u(a.$t("Take Selfie Photo")),1)]),e("div",null,[e("div",Xe,[e("div",et,[e("button",{onClick:s[3]||(s[3]=n=>I.value=!0),class:"relative w-full h-full group"},[l(o).identity_selfie_image?(_(),b("img",{key:0,src:l(o).identity_selfie_image,alt:"",class:"w-full h-auto"},null,8,tt)):P("",!0),e("span",{class:T(["absolute inset-0 w-full h-full bg-transparent hover:bg-white hover:bg-opacity-50",l(o).identity_selfie_image?"hidden group-hover:block ":"block"])},[e("span",st,[t(y,{icon:"camera",class:"w-12 h-auto text-center text-black"})])],2)])]),e("div",at,[t(Y,null,{default:i(()=>[p(u(a.$t("Take a selfie of your self with a natural expression"))+". ",1)]),_:1}),t(Y,null,{default:i(()=>[p(u(a.$t("Make sure your whole face is visible, centered and your eyes are open"))+". ",1)]),_:1}),t(Z,null,{default:i(()=>[p(u(a.$t("Do not copy your ID or use screenshots of your ID"))+". ",1)]),_:1}),t(Z,null,{default:i(()=>[p(u(a.$t("Do not hide or alter pars of your face (No hats/beauty images / filters / headgear)"))+". ",1)]),_:1})])]),t(V,{class:"mt-2",message:l(o).errors.identity_selfie_image},null,8,["message"])]),e("div",null,[e("p",lt,u(a.$t("File size must be between 10KB and 5120KB in jpg/jpeg/png format"))+". ",1)])]),e("div",ot,[e("div",null,[t(L,{onClick:s[4]||(s[4]=n=>v.value=!0)},{icon:i(()=>[$.value?(_(),b("img",{key:0,src:$.value,class:"h-full w-auto max-h-[110px]"},null,8,it)):(_(),q(y,{key:1,icon:"camera",class:"w-12 h-auto text-center text-white"}))]),default:i(()=>[p(" "+u(a.$t("Front")),1)]),_:1}),t(V,{class:"mt-2",message:l(o).errors.identity_front_image},null,8,["message"])]),e("div",null,[t(L,{onClick:s[5]||(s[5]=n=>x.value=!0)},{icon:i(()=>[m.value?(_(),b("img",{key:0,src:m.value,class:"h-full w-auto max-h-[110px]"},null,8,nt)):(_(),q(y,{key:1,icon:"camera",class:"w-12 h-auto text-center text-white"}))]),default:i(()=>[p(" "+u(a.$t("Back")),1)]),_:1}),t(V,{class:"mt-2",message:l(o).errors.identity_back_image},null,8,["message"])])])])]),footer:i(()=>[e("div",rt,[j(t(X,{class:T({"opacity-25":l(o).processing}),disabled:l(o).processing,onClick:s[6]||(s[6]=n=>N())},{default:i(()=>[p(u(a.$t("Verify")),1)]),_:1},8,["class","disabled"]),[[B,l(k)!=="Verified"]])])]),_:1},8,["title"])]),_:1})]),t(W,{"should-upload":!1,show:v.value,"current-image-url":$.value,modelValue:l(o).identity_front_image,"onUpdate:modelValue":s[7]||(s[7]=n=>l(o).identity_front_image=n),onClose:s[8]||(s[8]=n=>v.value=!1),onSelected:M},null,8,["show","current-image-url","modelValue"]),t(W,{"should-upload":!1,show:x.value,"current-image-url":m.value,modelValue:l(o).identity_back_image,"onUpdate:modelValue":s[9]||(s[9]=n=>l(o).identity_back_image=n),onClose:s[10]||(s[10]=n=>x.value=!1),onSelected:C},null,8,["show","current-image-url","modelValue"]),t(Te,{modelValue:l(o).identity_selfie_image,"onUpdate:modelValue":s[11]||(s[11]=n=>l(o).identity_selfie_image=n),show:I.value,onClose:s[12]||(s[12]=n=>I.value=!1)},null,8,["modelValue","show"]),t(be,{title:"Congratulations",message:"Your identity verification has been successfully sent. Please wait for approval.",show:g.value,onClose:s[13]||(s[13]=n=>g.value=!1)},null,8,["show"])]),_:1})],64)}}};export{Qt as default};
