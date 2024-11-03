import"./base.1b1bd1ad.js";import{v as b}from"./loading.0484db5f.js";import{T as v,r as V,d as c,b as s,u as t,w as r,F as h,o as f,Z as w,a as m,e as j,q as _,I as C,f as i,t as n,a5 as S}from"./app.8ff0f107.js";import{_ as k}from"./GuestLayout.de9ee2f8.js";import{G as x}from"./GuestTwoColumnLayout.f9249971.js";import{C as U}from"./Card.79095136.js";import{_ as q}from"./CardContent.953c4953.js";import{_ as u}from"./InputLabel.9cf3d0c8.js";import{_ as d}from"./TextInput.42ee8067.js";import{_ as p}from"./InputError.f29c6013.js";import{_ as N}from"./PrimaryButton.11a51cad.js";import"./index.412eb292.js";import"./GuestNavbar.9e8bb035.js";import"./ResponsiveNavLink.118cd62e.js";import"./SecondaryButton.5221202e.js";import"./DateTranslation.68228c64.js";import"./dayjs.min.61a7718e.js";import"./XMarkIcon.4621726c.js";import"./index.f405b57e.js";const T={key:0,class:"flex justify-center my-4"},B={class:"col-span-1"},M={class:"col-span-1"},D={class:"col-span-2"},E={class:"col-span-2"},F={class:"relative col-span-2"},G=["placeholder"],re={__name:"Contact",setup(L){const a=v({first_name:null,last_name:null,email:null,subject:null,message:null}),g=V(!1);function $(){a.post(route("contacts.store"),{preserveState:!0,preserveScroll:!0,onSuccess:()=>{g.value=!0,a.reset()}})}return(e,l)=>{const y=b;return f(),c(h,null,[s(t(w),{title:"Contact"}),s(k,null,{default:r(()=>[s(x,null,{default:r(()=>[s(U,null,{default:r(()=>[s(q,{title:e.$t("contact")},{body:r(()=>[g.value?(f(),c("div",T,l[5]||(l[5]=[m("p",{class:"text-sm text-primary"}," Your message was successfully sent, we will get back to you shortly. ",-1)]))):j("",!0),_((f(),c("form",{class:"grid grid-cols-2 gap-4",onSubmit:C($,["prevent"])},[m("div",B,[s(u,{color:"text-primary"},{default:r(()=>[i(n(e.$t("first-name")),1)]),_:1}),s(d,{type:"text",modelValue:t(a).first_name,"onUpdate:modelValue":l[0]||(l[0]=o=>t(a).first_name=o),placeholder:e.$t("please")+e.$t("enter")+e.$t("first-name"),"auto-complete":"given-name","aria-required":"true"},null,8,["modelValue","placeholder"]),s(p,{message:t(a).errors.first_name,class:"px-4"},null,8,["message"])]),m("div",M,[s(u,{color:"text-primary"},{default:r(()=>[i(n(e.$t("surname")),1)]),_:1}),s(d,{type:"text",modelValue:t(a).last_name,"onUpdate:modelValue":l[1]||(l[1]=o=>t(a).last_name=o),placeholder:e.$t("please")+e.$t("enter")+e.$t("surname"),"auto-complete":"family-name","aria-required":"true"},null,8,["modelValue","placeholder"]),s(p,{message:t(a).errors.last_name,class:"px-4"},null,8,["message"])]),m("div",D,[s(u,{color:"text-primary"},{default:r(()=>[i(n(e.$t("email")),1)]),_:1}),s(d,{type:"text",modelValue:t(a).email,"onUpdate:modelValue":l[2]||(l[2]=o=>t(a).email=o),placeholder:e.$t("please")+e.$t("enter")+e.$t("Email Address"),"auto-complete":"email","aria-required":"true"},null,8,["modelValue","placeholder"]),s(p,{message:t(a).errors.email,class:"px-4"},null,8,["message"])]),m("div",E,[s(u,{color:"text-primary"},{default:r(()=>[i(n(e.$t("subject")),1)]),_:1}),s(d,{type:"text",modelValue:t(a).subject,"onUpdate:modelValue":l[3]||(l[3]=o=>t(a).subject=o),placeholder:e.$t("please")+e.$t("enter")+e.$t("subject")},null,8,["modelValue","placeholder"]),s(p,{message:t(a).errors.subject,class:"px-4"},null,8,["message"])]),m("div",F,[s(u,{color:"text-primary"},{default:r(()=>[i(n(e.$t("message")),1)]),_:1}),_(m("textarea",{placeholder:e.$t("please write a message or briefly what happen"),class:"block w-full rounded-2xl border-gray-300 px-4 shadow-sm focus:border-primary focus:ring-primary sm:text-sm disabled:bg-gray-100 h-[20ch]","onUpdate:modelValue":l[4]||(l[4]=o=>t(a).message=o)},null,8,G),[[S,t(a).message]])]),s(p,{message:t(a).errors.subject},null,8,["message"]),s(N,{class:"col-span-2"},{default:r(()=>[i(n(e.$t("submit")),1)]),_:1})],32)),[[y,t(a).processing]])]),_:1},8,["title"])]),_:1})]),_:1})]),_:1})],64)}}};export{re as default};
