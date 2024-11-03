import{Q as $,r as w,T as k,c as C,w as l,A as T,u as d,o as m,f as c,t as o,a as e,d as _,b as v,e as g,q as D,a2 as M}from"./app.8ff0f107.js";import{_ as A}from"./DateTranslation.68228c64.js";import{_ as S}from"./PrimaryButton.11a51cad.js";import{_ as B}from"./AppLayout.ac3aab9c.js";import{_ as V}from"./GuestLayout.de9ee2f8.js";import"./dayjs.min.61a7718e.js";import"./index.f405b57e.js";import"./ResponsiveNavLink.118cd62e.js";import"./SecondaryButton.5221202e.js";import"./Avatar.vue_vue_type_style_index_0_lang.13aa623b.js";import"./StarIcon.5dbdfceb.js";import"./MapPinIcon.afa94ea1.js";import"./XMarkIcon.4621726c.js";import"./Modal.b3ff11aa.js";import"./InvitationPlayerCard.1c9614ad.js";import"./index.1938c188.js";import"./CheckIcon.7c9aeea7.js";/* empty css                                                  */import"./GuestNavbar.9e8bb035.js";const N={class:"grid w-full px-8 lg:grid-cols-2"},Y={class:"col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4"},j={class:"flex justify-center my-4"},E={class:"text-2xl font-bold uppercase text-primary"},H={key:0,class:"relative flex-grow p-4 border-2 rounded-lg border-stone-400"},L=["innerHTML"],O={class:"absolute z-20 p-2 text-xs font-bold uppercase bg-white -top-4 left-4 text-primary"},U={key:1,class:""},q={class:"flex flex-col justify-center gap-2"},z={for:"terms",class:"text-sm font-medium text-primary"},I=["value"],P={class:"mt-2"},me={__name:"TermsOfService",props:{terms:Object},setup(s){var p,u,f,h;const b=s,y=(u=(p=$().props)==null?void 0:p.value.auth)==null?void 0:u.user,a=w(!0),r=k({termsAndConditions:(h=(f=b.terms)==null?void 0:f.id)!=null?h:null});function x(){r.patch(route("terms.and.condition.store",r.termsAndConditions))}return(t,i)=>(m(),C(T(d(y)?B:V),{title:t.$t("Terms of Service")},{header:l(()=>[c(o(t.$t("Security")),1)]),default:l(()=>[e("div",N,[e("div",Y,[e("div",j,[e("h2",E,o(t.$t("Terms of Service")),1)]),s.terms?(m(),_("div",H,[e("div",{class:"w-full max-h-[400px] overflow-auto hideScrollBar",innerHTML:s.terms.content},null,8,L),e("div",O,[c(o(t.$t("updated"))+" ",1),v(A,{format:"DD MMMM YYYY",start:s.terms.created_at},null,8,["start"])])])):g("",!0),t.$page.props.auth.user&&s.terms&&s.terms.version!==t.$page.props.auth.user.accepted_terms_and_conditions_version?(m(),_("div",U,[e("div",q,[e("label",z,o(t.$t("I agree")),1),D(e("input",{type:"radio",value:s.terms.id,id:"terms","onUpdate:modelValue":i[0]||(i[0]=n=>d(r).termsAndConditions=n),checked:!1,onChange:i[1]||(i[1]=n=>{n.target.checked?a.value=!1:a.value=!0}),class:"accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"},null,40,I),[[M,d(r).termsAndConditions]])]),e("div",P,[v(S,{disabled:a.value,onClick:x},{default:l(()=>[c(o(t.$t("UPDATE")),1)]),_:1},8,["disabled"])])])):g("",!0)])])]),_:1},8,["title"]))}};export{me as default};