import{f as v,F as b,Z as k}from"./index.1938c188.js";import{N as c,j as y,o as p,c as $,w as r,m as w,u as a,b as n,d,a as m,f as S,t as _,n as B,s as A,Q as z}from"./app.8ff0f107.js";import{e as C,_ as N,a as V}from"./AppSearchInput.vue_vue_type_script_setup_true_lang.77cc1d10.js";import{_ as D}from"./Avatar.vue_vue_type_style_index_0_lang.13aa623b.js";import{c as T,a as j}from"./index.f405b57e.js";const E=c({__name:"AppMap",props:{latitude:{},longitude:{}},setup(i){const e=i,o="AIzaSyC9lN0B2EalTvLS_dNDWE1BmCBKLTDZxsI",s=y(()=>({lat:parseFloat(e.latitude),lng:parseFloat(e.longitude)}));return(t,l)=>(p(),$(a(b),{"api-key":a(o),center:a(s),style:{width:"100%",height:"100px"},zoom:5},{default:r(()=>[w(t.$slots,"marker",{position:a(s)},()=>[n(a(v),{options:{position:a(s)}},null,8,["options"])])]),_:3},8,["api-key","center"]))}}),F=C("",{variants:{direction:{vertical:"flex-col gap-1 ",horizontal:"gap-3 justify-between"}},defaultVariants:{direction:"vertical"}}),L=c({__name:"TeamSimpleAvatar",props:{team:{},direction:{}},setup(i){return(e,o)=>{const s=D,t=A,l=N;return p(),d("div",{class:B(("cn"in e?e.cn:a(T))("flex items-center",a(F)({direction:e.direction})))},[n(s,{size:"lg","image-url":e.team.team_logo_url,username:e.team.name},null,8,["image-url","username"]),m("div",null,[n(t,{class:"text-sm font-semibold uppercase line-clamp-1",href:e.route("teams.show",[e.team])},{default:r(()=>[S(_(`${e.team.name} (${e.team.code})`),1)]),_:1},8,["href"]),n(l,{class:"justify-center mx-auto",disabled:"",modelValue:4})])],2)}}}),M={class:"card"},I={class:"flex items-center justify-between gap-3"},K={class:"font-semibold whitespace-nowrap"},q=c({__name:"MatchCard",props:{match:{}},setup(i){const e=i,o=z().props.auth.user,s=j(o.current_latitude,o.current_longitude,e.match.stadium.latitude,e.match.stadium.longitude);return(t,l)=>{const u=L,f=V,h=E;return p(),d("div",M,[m("div",I,[n(u,{team:t.match.team_1},null,8,["team"]),m("p",K,_(t.$t("point1-vs-point2",{point1:String(t.match.point_team_1),point2:String(t.match.point_team_2)})),1),n(u,{team:t.match.team_2},null,8,["team"])]),n(h,{class:"mt-5 overflow-hidden rounded-md",style:{height:"100px"},disableDefaultUi:!0,latitude:t.match.stadium.latitude,longitude:t.match.stadium.longitude},{marker:r(({position:g})=>[n(a(k),{options:{position:g}},{default:r(()=>[n(f,{size:"sm",color:"black",label:t.$t("distance-km",{distance:a(s)})},null,8,["label"])]),_:2},1032,["options"])]),_:1},8,["latitude","longitude"])])}}});export{q as _};
