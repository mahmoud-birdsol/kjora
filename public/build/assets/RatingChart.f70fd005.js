import{aD as l,k as c,o as r,c as p,u as d,d as g,t as h}from"./app.8ff0f107.js";const x={key:1,class:"text-sm font-normal text-gray-100 h-56 grid place-items-center normal-case"},y={__name:"RatingChart",props:{labels:{type:Array,default:["Agility","Stamina","Sttrngth","Passing","Shooting","pace"]},data:Array},setup(a){const t=a,n={chart:{id:"vuechart-example",redrawOnWindowResize:!0,foreColor:"#000"},responsive:[{breakpoint:500,options:{xaxis:{labels:{style:{fontSize:"9px"}}}}}],xaxis:{categories:t.labels,labels:{style:{fontSize:"12px",fontFamily:"Helvetica, Arial, sans-serif",fontWeight:400,cssClass:"apexcharts-xaxis-label"}}},yaxis:{show:!1,min:0,max:5,tickAmount:10,labels:{show:!0,style:{fontSize:"12px",fontWeight:800}}},stroke:{show:!0,colors:["rgb(253,224,60)"]},fill:{colors:["rgb(253 ,224 ,71)"],opacity:1,type:"solid"},plotOptions:{radar:{polygons:{strokeWidth:0,fill:{colors:["rgb(0,100,0)","#FFF"]}}}},markers:{size:3,colors:["#fff"],strokeColor:"rgba(0, 100, 0)",strokeWidth:1,hover:{size:4}},tooltip:{enabled:!0,custom:function({series:e,seriesIndex:o,dataPointIndex:s,w:f}){return'<div class="arrow_box"><span style="font-size:9px; padding:0px 10px; color:black; ">'+e[o][s].toFixed(2)+"</span></div>"}}},i=l(()=>{var e;return[{name:"Rating",data:t.data.length?t.data:new Array((e=t.labels)==null?void 0:e.length).fill(0)}]});return(e,o)=>{const s=c("apexchart");return a.labels.length?(r(),p(s,{key:0,width:"100%",type:"radar",options:n,series:d(i)},null,8,["series"])):(r(),g("div",x,h(e.$t("no rating categories for this position till now")),1))}}};export{y as _};
