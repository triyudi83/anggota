!function(s){"use strict";var t=function(){this.$body=s("body"),this.$realData=[]};t.prototype.createPlotGraph=function(t,a,e,o,r,l,i){s.plot(s(t),[{data:a,label:o[0],color:r[0]},{data:e,label:o[1],color:r[1]}],{series:{lines:{show:!0,fill:!0,lineWidth:2,fillColor:{colors:[{opacity:.5},{opacity:.5}]}},points:{show:!1},shadowSize:0},legend:{position:"nw"},grid:{hoverable:!0,clickable:!0,borderColor:l,borderWidth:1,labelMargin:10,backgroundColor:i},yaxis:{min:0,max:15,color:"rgba(0,0,0,0.1)"},xaxis:{color:"rgba(0,0,0,0.1)"},tooltip:!0,tooltipOpts:{content:"%s: Value of %x is %y",shifts:{x:-60,y:25},defaultTheme:!1}})},t.prototype.createPieGraph=function(t,a,e,o){var r=[{label:a[0],data:e[0]},{label:a[1],data:e[1]},{label:a[2],data:e[2]}],l={series:{pie:{show:!0}},legend:{show:!0},grid:{hoverable:!0,clickable:!0},colors:o,tooltip:!0,tooltipOpts:{content:"%s, %p.0%"}};s.plot(s(t),r,l)},t.prototype.randomData=function(){for(0<this.$realData.length&&(this.$realData=this.$realData.slice(1));this.$realData.length<300;){var t=(0<this.$realData.length?this.$realData[this.$realData.length-1]:50)+10*Math.random()-5;t<0?t=0:100<t&&(t=100),this.$realData.push(t)}for(var a=[],e=0;e<this.$realData.length;++e)a.push([e,this.$realData[e]]);return a},t.prototype.createRealTimeGraph=function(t,a,e){return s.plot(t,[a],{colors:e,series:{lines:{show:!0,fill:!0,lineWidth:2,fillColor:{colors:[{opacity:.45},{opacity:.45}]}},points:{show:!1},shadowSize:0},grid:{show:!0,aboveData:!1,color:"#dcdcdc",labelMargin:15,axisMargin:0,borderWidth:0,borderColor:null,minBorderMargin:5,clickable:!0,hoverable:!0,autoHighlight:!1,mouseActiveRadius:20},tooltip:!0,tooltipOpts:{content:"Value is : %y.0%",shifts:{x:-30,y:-50}},yaxis:{min:0,max:100,color:"rgba(0,0,0,0.1)"},xaxis:{show:!1}})},t.prototype.createDonutGraph=function(t,a,e,o){var r=[{label:a[0],data:e[0]},{label:a[1],data:e[1]},{label:a[2],data:e[2]},{label:a[3],data:e[3]},{label:a[4],data:e[4]}],l={series:{pie:{show:!0,innerRadius:.7}},legend:{show:!0,labelFormatter:function(t,a){return'<div style="font-size:14px;">&nbsp;'+t+"</div>"},labelBoxBorderColor:null,margin:50,width:20,padding:1},grid:{hoverable:!0,clickable:!0},colors:o,tooltip:!0,tooltipOpts:{content:"%s, %p.0%"}};s.plot(s(t),r,l)},t.prototype.init=function(){this.createPlotGraph("#website-stats",[[0,9],[1,8],[2,5],[3,8],[4,5],[5,14],[6,10]],[[0,5],[1,12],[2,4],[3,3],[4,12],[5,8],[6,4]],["Marketplace","Other Market"],["#fcc24c","#54cc96"],"#f5f5f5","#fff");this.createPieGraph("#pie-chart #pie-chart-container",["Marketplace","Other Market","Direct Sales"],[20,30,15],["#fcc24c","#54cc96","#f0f1f4"]);var a=this.createRealTimeGraph("#flotRealTime",this.randomData(),["#fcc24c"]);a.draw();var e=this;!function t(){a.setData([e.randomData()]),a.draw(),setTimeout(t,(s("html").hasClass("mobile-device"),1e3))}();this.createDonutGraph("#donut-chart #donut-chart-container",["Marketplace","Other Market","Direct Sales"],[29,20,18],["#fcc24c","#54cc96","#f0f1f4"])},s.FlotChart=new t,s.FlotChart.Constructor=t}(window.jQuery),function(t){"use strict";window.jQuery.FlotChart.init()}();