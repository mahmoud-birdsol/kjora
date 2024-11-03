import{r as x,Q as $,T as w,d,b as m,u as r,c as C,w as p,A as D,F as M,o as l,Z as P,f as u,t as s,a as e,e as y,q as B,a2 as T}from"./app.8ff0f107.js";import{_ as V}from"./PrimaryButton.11a51cad.js";import{_ as N}from"./AppLayout.ac3aab9c.js";import"./dayjs.min.61a7718e.js";import{_ as Y}from"./GuestLayout.de9ee2f8.js";import{_ as j}from"./DateTranslation.68228c64.js";import"./index.f405b57e.js";import"./ResponsiveNavLink.118cd62e.js";import"./SecondaryButton.5221202e.js";import"./Avatar.vue_vue_type_style_index_0_lang.13aa623b.js";import"./StarIcon.5dbdfceb.js";import"./MapPinIcon.afa94ea1.js";import"./XMarkIcon.4621726c.js";import"./Modal.b3ff11aa.js";import"./InvitationPlayerCard.1c9614ad.js";import"./index.1938c188.js";import"./CheckIcon.7c9aeea7.js";/* empty css                                                  */import"./GuestNavbar.9e8bb035.js";const S={class:"grid w-full px-8 lg:grid-cols-2"},A={class:"col-start-2 bg-white rounded-2xl p-6 w-full min-h-[500px] flex flex-col gap-4"},E={class:"flex justify-center my-4"},F={class:"text-2xl font-bold uppercase text-primary"},H={key:0,class:"relative flex-grow p-4 border-2 rounded-lg border-stone-400"},L=["innerHTML"],U={class:"absolute z-20 p-2 text-xs font-bold uppercase bg-white -top-4 left-4 text-primary"},q={key:1,class:""},z={class:"flex flex-col justify-center gap-2 mt-4"},I={for:"cookies",class:"text-sm font-medium text-primary"},O=["value"],Q={class:"mt-2"},pe={__name:"CookiesPolicy",props:{cookies:Object},setup(t){var f,k,h,_;const v=t,c=x(!0),g=(k=(f=$().props)==null?void 0:f.value.auth)==null?void 0:k.user,i=w({cookiePolicy:(_=(h=v.cookies)==null?void 0:h.id)!=null?_:null});function b(){i.patch(route("cookies.policy.store",i.cookiePolicy))}return(o,a)=>(l(),d(M,null,[m(r(P),{title:"Cookie use"}),(l(),C(D(r(g)?N:Y),{title:o.$t("cookie use")},{header:p(()=>[u(s(o.$t("Security")),1)]),default:p(()=>[e("div",S,[e("div",A,[e("div",E,[e("h2",F,s(o.$t("cookie use")),1)]),t.cookies?(l(),d("div",H,[e("div",{class:"w-full max-h-[400px] overflow-auto hideScrollBar",innerHTML:t.cookies.content},null,8,L),e("div",U,[u(s(o.$t("updated"))+" ",1),m(j,{format:"DD MMMM YYYY",start:t.cookies.created_at},null,8,["start"])])])):y("",!0),o.$page.props.user&&t.cookies&&t.cookies.version!==o.$page.props.auth.user.accepted_cookie_policy_version?(l(),d("div",q,[e("div",z,[e("label",I,s(o.$t("I agree")),1),B(e("input",{type:"radio",value:t.cookies.id,id:"cookies","onUpdate:modelValue":a[0]||(a[0]=n=>r(i).cookiePolicy=n),checked:!1,onChange:a[1]||(a[1]=n=>{n.target.checked?c.value=!1:c.value=!0}),class:"accent-primary checked:bg-primary focus:bg-primary focus:ring-primary"},null,40,O),[[T,r(i).cookiePolicy]])]),e("div",Q,[m(V,{disabled:c.value,onClick:b},{default:p(()=>[u(s(o.$t("UPDATE")),1)]),_:1},8,["disabled"])])])):y("",!0)])])]),_:1},8,["title"]))],64))}};export{pe as default};
