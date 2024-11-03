import{o as v,d as g,a as e,Q as M,T as B,r as _,b as r,w as $,I as w,n as x,u as l,q as p,a2 as f,t as d,F as V,g as D,f as k}from"./app.8ff0f107.js";import{_ as n}from"./InputError.f29c6013.js";import{_ as u}from"./InputLabel.9cf3d0c8.js";import{_ as F}from"./PrimaryButton.11a51cad.js";import{_ as c}from"./TextInput.42ee8067.js";import{_ as U}from"./RichSelectInput.2cc41687.js";import{_ as S}from"./SuccessMessageModal.b452fe2d.js";import{_ as j}from"./UploadImageField.b9566f75.js";import{_ as q}from"./Avatar.vue_vue_type_style_index_0_lang.13aa623b.js";import{_ as A}from"./Title.f9acf21c.js";import{E}from"./index.04921f9c.js";import"./index.f405b57e.js";import"./base.1b1bd1ad.js";import"./index.412eb292.js";import"./loading.0484db5f.js";/* empty css                        */import"./floating-ui.vue.esm.b8000c53.js";import"./error.7e8331f1.js";import"./scroll.2986c3c8.js";import"./debounce.db0f0bcf.js";import"./PlayIcon.11e5e915.js";import"./CheckIcon.7c9aeea7.js";import"./Modal.b3ff11aa.js";import"./XMarkIcon.4621726c.js";import"./Crop.ae2eb42b.js";import"./PlusCircleIcon.76342808.js";import"./dayjs.min.61a7718e.js";import"./index.77b13ae5.js";import"./plugin-vue_export-helper.c628866e.js";import"./use-form-common-props.317c2149.js";import"./index.cd27f29d.js";import"./index.5c95d672.js";import"./index.92c919b4.js";import"./_Uint8Array.27af0212.js";function I(o,m){return v(),g("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor","aria-hidden":"true","data-slot":"icon"},[e("path",{d:"M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"})])}const N={class:"w-full mt-8 sm:flex sm:justify-between sm:space-x-4 lg:grid lg:grid-cols-2"},Y={class:"w-full p-6 bg-white rounded-md lg:col-start-2"},L={class:"flex items-center justify-center sm:justify-end sm:-mt-12"},T={class:"grid grid-cols-1 gap-4 mt-12 sm:grid-cols-2"},z={class:"mt-4 sm:flex sm:justify-between"},Z={class:"mt-4 sm:mt-0"},O={class:"mis-4"},Q={class:"flex items-center gap-x-2"},R=["id","value"],G=["for"],H={class:"mt-4 sm:mt-0"},J={class:"mis-4"},K={class:"flex items-center gap-x-2"},W=["id","value"],X=["for"],ee={class:"mt-4 sm:mt-0"},re={class:"mis-4"},le={class:"flex items-center gap-x-2"},ae={for:"left",class:"text-sm font-medium text-black"},se={class:"flex items-center gap-x-2"},te={for:"right",class:"text-sm font-medium text-black"},oe={class:"mt-4"},Le={__name:"UpdateProfileInformationForm",props:{user:Object,countries:Array,positions:Array},setup(o){const m=o,b=M().props.locale,a=B({_method:"PUT",first_name:m.user.first_name,last_name:m.user.last_name,username:m.user.username,email:m.user.email,country_id:m.user.country_id,club_id:m.user.club_id,password_confirmation:m.user.password_confirmation,date_of_birth:m.user.date_of_birth,terms:!0,phone:m.user.phone,position_id:m.user.position_id,gender:m.user.gender,preferred_foot:m.user.preferred_foot,avatar:m.user.avatar_url}),y=_(!1),P=()=>{a.post(route("user-profile-information.update"),{errorBag:"updateProfileInformation",preserveScroll:!1,onSuccess:()=>{y.value=!0}})},h=_(!1);return(i,s)=>(v(),g(V,null,[e("div",N,[e("div",Y,[r(A,{class:"my-4"},{default:$(()=>[k(d(i.$t("update")),1)]),_:1}),e("form",{onSubmit:w(P,["prevent"])},[e("div",L,[e("button",{class:"relative mt-2",onClick:s[0]||(s[0]=w(t=>h.value=!0,["prevent"]))},[r(q,{"image-url":o.user.avatar_url,username:o.user.name,border:!0,borderColor:i.state!=="Premium"?"primary":"golden",size:"xlg",id:o.user.id,enableLightBox:!1},null,8,["image-url","username","borderColor","id"]),e("div",{class:x(["absolute bottom-0 p-1 rounded-full ltr:right-0 rtl:left-0",i.state!=="Premium"?"text-white bg-primary hover:bg-white hover:text-primary":"text-white bg-golden hover:bg-white hover:text-golden"])},[r(l(I),{class:"w-3 [&+div]:hover:block"})],2)]),r(j,{"current-image-url":o.user.avatar_url,show:h.value,"model-name":"\\App\\Models\\User","model-id":o.user.id,"should-upload":!0,"collection-name":"avatar",onClose:s[1]||(s[1]=t=>h.value=!1)},null,8,["current-image-url","show","model-id"])]),e("div",T,[e("div",null,[r(u,{color:"primary",for:"first_name",value:i.$t("First Name")},null,8,["value"]),r(c,{type:"text",value:o.user.first_name,placeholder:"Please enter your first name","auto-complete":"given-name","aria-required":"true",disabled:!0,autofocus:""},null,8,["value"]),r(n,{class:"mt-2",message:l(a).errors.first_name},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"last_name",value:i.$t("Surname")},null,8,["value"]),r(c,{type:"text",value:o.user.last_name,placeholder:"Please enter your last name","auto-complete":"sur-name","aria-required":"true",disabled:!0},null,8,["value"]),r(n,{class:"mt-2",message:l(a).errors.last_name},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"email",value:i.$t("Email Address")},null,8,["value"]),r(c,{type:"email",value:o.user.email,placeholder:"Please enter your email address","auto-complete":"email","aria-required":"true",disabled:!0},null,8,["value"]),r(n,{class:"mt-2",message:l(a).errors.email},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"country",value:i.$t("Country")},null,8,["value"]),r(U,{options:o.countries,"value-name":"id","text-name":"name","image-name":"flag",modelValue:l(a).country_id,"onUpdate:modelValue":s[2]||(s[2]=t=>l(a).country_id=t)},null,8,["options","modelValue"]),r(n,{class:"mt-2",message:l(a).errors.country_id},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"club",value:i.$t("Favorite Club")},null,8,["value"]),r(U,{source:"/api/clubs","value-name":"id","text-name":"name","image-name":"logo",append:o.user.club,modelValue:l(a).club_id,"onUpdate:modelValue":s[3]||(s[3]=t=>l(a).club_id=t)},null,8,["append","modelValue"]),r(n,{class:"mt-2",message:l(a).errors.club_id},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"date_of_birth",value:i.$t("Date of birth"),disabled:!0},null,8,["value"]),r(l(E),{modelValue:l(a).date_of_birth,"onUpdate:modelValue":s[4]||(s[4]=t=>l(a).date_of_birth=t),class:"w-full",placeholde:"DD/MM/YYYY",disabled:!0},null,8,["modelValue"]),r(n,{class:"mt-2",message:l(a).errors.date_of_birth},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"phone",value:i.$t("Phone")},null,8,["value"]),r(c,{type:"tel",disabled:!0,value:o.user.phone},null,8,["value"]),r(n,{class:"mt-2",message:l(a).errors.phone},null,8,["message"])]),e("div",null,[r(u,{color:"primary",for:"username",value:i.$t("Username")},null,8,["value"]),r(c,{type:"text",value:o.user.username,modelValue:l(a).username,"onUpdate:modelValue":s[5]||(s[5]=t=>l(a).username=t),placeholder:"@","auto-complete":"username","aria-required":"true",disabled:!0},null,8,["value","modelValue"]),r(n,{class:"mt-2",message:l(a).errors.username},null,8,["message"])])]),e("div",z,[e("div",Z,[e("div",null,[r(u,{color:"primary",value:i.$t("gender")},null,8,["value"]),e("div",O,[e("div",Q,[p(e("input",{type:"radio",checked:"",id:o.user.gender,value:o.user.gender,disabled:"","onUpdate:modelValue":s[6]||(s[6]=t=>l(a).gender=t),class:"accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"},null,8,R),[[f,l(a).gender]]),e("label",{for:o.user.gender,class:"text-sm font-medium text-black"},d(i.$t(o.user.gender)),9,G)])])])]),e("div",H,[r(u,{color:"primary",value:i.$t("position")},null,8,["value"]),e("div",J,[(v(!0),g(V,null,D(o.positions,t=>(v(),g("div",K,[p(e("input",{type:"radio",id:t.name[l(b)],value:t.id,"onUpdate:modelValue":s[7]||(s[7]=C=>l(a).position_id=C),class:"accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"},null,8,W),[[f,l(a).position_id]]),e("label",{for:t.name[l(b)],class:"text-sm font-medium text-black"},d(t.name[l(b)]),9,X)]))),256))])]),e("div",ee,[r(u,{color:"primary",value:i.$t("Preferred Foot")},null,8,["value"]),e("div",re,[e("div",le,[p(e("input",{type:"radio",id:"left",value:"left","onUpdate:modelValue":s[8]||(s[8]=t=>l(a).preferred_foot=t),class:"accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"},null,512),[[f,l(a).preferred_foot]]),e("label",ae,d(i.$t("left")),1)]),e("div",se,[p(e("input",{type:"radio",id:"right",value:"right","onUpdate:modelValue":s[9]||(s[9]=t=>l(a).preferred_foot=t),class:"accent-primary checked:bg-primary focus:bg-primary focus:ring-primary ltr:max-sm:ml-4 rtl:max-sm:mr-4"},null,512),[[f,l(a).preferred_foot]]),e("label",te,d(i.$t("right")),1)])])])]),e("div",oe,[r(F,{class:x({"opacity-25":l(a).processing}),disabled:l(a).processing},{default:$(()=>[k(d(i.$t("Update")),1)]),_:1},8,["class","disabled"])])],32)])]),r(S,{show:y.value,position:"right",title:i.$t("account"),message:"Congratulations your account has been successfully updated.",onClose:s[10]||(s[10]=t=>y.value=!1)},null,8,["show","title"])],64))}};export{Le as default};