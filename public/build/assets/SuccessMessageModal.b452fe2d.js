import{_ as m}from"./Modal.b3ff11aa.js";import{_ as c}from"./PrimaryButton.11a51cad.js";import{j as d,o as i,c as x,w as n,a as t,t as a,d as f,b as u,f as p,e as y}from"./app.8ff0f107.js";const w={class:"bg-white rounded-xl p-6 flex flex-col justify-between min-h-[500px]"},h={class:"flex justify-center my-4"},g={class:"text-xl text-primary font-bold uppercase"},_={class:"flex justify-center my-4"},$={class:"text-xs text-gray-900"},k={key:0,class:"flex justify-center my-4"},B={__name:"SuccessMessageModal",props:{show:{type:Boolean,default:!1},title:{required:!0,type:String},message:{required:!0,type:String},action:{required:!1,type:String},position:{required:!1,type:String,default:"center"}},setup(e){const l=e;return d(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[l.maxWidth]),(o,s)=>(i(),x(m,{show:e.show,onClose:s[1]||(s[1]=r=>o.$emit("close")),"max-width":"md",position:e.position},{default:n(()=>[t("div",w,[t("div",h,[t("h2",g,a(e.title),1)]),t("div",_,[t("p",$,a(e.message),1)]),e.action?y("",!0):(i(),f("div",k,[u(c,{onClick:s[0]||(s[0]=r=>o.$emit("close"))},{default:n(()=>[p(a(o.$t("ok")),1)]),_:1})]))])]),_:1},8,["show","position"]))}};export{B as _};
