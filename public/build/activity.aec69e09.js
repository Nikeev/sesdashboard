(self.webpackChunk=self.webpackChunk||[]).push([[471],{6093:(t,e,a)=>{"use strict";var s=a(144),n=a(7405),i=a(5749),o=a(3775),l=a(3684),r=a(6333),c=(a(9043),function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("app-filter-form",{on:{reload:t.loadData,search:function(e){t.search=e},"date-from":function(e){t.dateFrom=e},"date-to":function(e){t.dateTo=e},"event-selected":function(e){t.eventSelected=e}}}),t._v(" "),a("b-table",{attrs:{hover:"","show-empty":"",fields:t.fields,items:t.rows,busy:t.isBusy},on:{"row-clicked":t.rowClicked},scopedSlots:t._u([{key:"empty",fn:function(e){return[a("div",{staticClass:"text-center lead"},[t._v("No emails to display")])]}},{key:"table-busy",fn:function(){return[a("div",{staticClass:"text-center text-primary my-2"},[a("b-spinner",{staticClass:"align-middle"})],1)]},proxy:!0},{key:"cell(status)",fn:function(e){return[a("i",{staticClass:"fas fa-dot-circle",class:"status-"+e.item.status}),t._v(" "),a("span",{staticClass:"text-capitalize"},[t._v(t._s(e.item.status))])]}},{key:"cell(subject)",fn:function(e){return[a("p",[a("b",[t._v(t._s(e.item.subject))])]),t._v(" "),a("p",[a("b",[t._v("To:")]),t._v(" "+t._s(e.item.destination.join(", ")))])]}},{key:"cell(timestamp)",fn:function(e){return[a("span",{attrs:{title:e.item.timestamp}},[t._v(" "+t._s(t._f("formatDate")(e.item.timestamp)))])]}}])}),t._v(" "),t.totalRows>t.perPage?a("b-pagination",{attrs:{size:"md","total-rows":t.totalRows,"per-page":t.perPage},model:{value:t.currentPage,callback:function(e){t.currentPage=e},expression:"currentPage"}}):t._e(),t._v(" "),a("app-email-details",{attrs:{"show-details":t.showDetails,"mail-id":t.selectedId},on:{"modal-closed":function(e){t.showDetails=!1}}})],1)});c._withStripped=!0;a(4916),a(4765);var d=a(9669),u=a.n(d),m=a(381),p=a.n(m),v=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-modal",{attrs:{title:"Email Details",size:"lg"},scopedSlots:t._u([{key:"modal-footer",fn:function(){return[a("div",{staticClass:"w-100"},[a("b-button",{staticClass:"float-right",attrs:{variant:"primary",size:"sm"},on:{click:function(e){t.showModal=!1}}},[t._v("\n          Close\n        ")])],1)]},proxy:!0}]),model:{value:t.showModal,callback:function(e){t.showModal=e},expression:"showModal"}},[t.detailsLoading?a("div",{staticClass:"text-center"},[a("b-spinner",{attrs:{variant:"primary"}})],1):t._e(),t._v(" "),t.emailDetails?a("div",[a("div",{staticClass:"table-responsive"},[a("table",{staticClass:"table"},[a("tbody",[a("tr",[a("th",[t._v("Subject")]),t._v(" "),a("td",[t._v(t._s(t.emailDetails.subject))])]),t._v(" "),a("tr",[a("th",[t._v("MessageId")]),t._v(" "),a("td",[t._v(t._s(t.emailDetails.messageId))])]),t._v(" "),a("tr",[a("th",[t._v("Destination")]),t._v(" "),a("td",[t._v(t._s(t.emailDetails.destination.join(", ")))])]),t._v(" "),a("tr",[a("th",[t._v("Source")]),t._v(" "),a("td",[t._v(t._s(t.emailDetails.source))])]),t._v(" "),a("tr",[a("th",[t._v("DateTime")]),t._v(" "),a("td",[t._v(t._s(t._f("formatDate")(t.emailDetails.timestamp))+" ("+t._s(t.emailDetails.timestamp)+" UTC)")])])])])]),t._v(" "),a("h5",[t._v("Events Log")]),t._v(" "),a("ul",{staticClass:"list-group"},t._l(t.emailDetails.emailEvents,(function(e){return a("li",{directives:[{name:"b-toggle",rawName:"v-b-toggle",value:"collapse-"+e.id,expression:"'collapse-' + emailEvent.id"}],key:e.id,staticClass:"list-group-item"},[a("div",[a("i",{staticClass:"fas fa-file-alt float-right small text-muted"}),t._v(" "),a("i",{staticClass:"far fa-dot-circle text-primary"}),t._v(" "),a("span",{staticClass:"text-capitalize lead"},[t._v(t._s(e.event))]),t._v(" "),a("small",[t._v(t._s(t._f("formatDate")(e.timestamp))+" ("+t._s(e.timestamp)+" UTC)")])]),t._v(" "),a("b-collapse",{staticClass:"bg-light p-4",attrs:{id:"collapse-"+e.id}},[a("pre",[a("code",[t._v(t._s(e.eventData))])])])],1)})),0)]):t._e()])};v._withStripped=!0;var f=a(3258),h=a(5193),j=a(3028);const g={name:"EmailDetails",props:["mailId","showDetails"],components:{BCollapse:f.k,BButton:h.T},directives:{"b-toggle":j.M},data:function(){return{showModal:this.showDetails,detailsLoading:!0,emailDetails:null}},methods:{loadDetails:function(){this.detailsLoading=!0,this.emailDetails=null;var t=this;u().get("/activity/details/api",{params:{id:t.mailId}}).then((function(e){console.log(e),t.emailDetails=e.data})).catch((function(e){console.log(e),t.detailsLoading=!1})).then((function(){t.detailsLoading=!1}))}},filters:{formatDate:function(t){return t?p()(t).locale(window.navigator.language).local().format("LLL"):""}},watch:{showDetails:function(){this.showModal=this.showDetails},showModal:function(){this.showModal?this.loadDetails():this.$emit("modal-closed",!0)}}};var _=a(1900),w=(0,_.Z)(g,v,[],!1,null,"fc0e117a",null);w.options.__file="assets/js/App/Components/Activity/EmailDetails.vue";const b=w.exports;var D=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-row",{staticClass:"mb-3"},[a("b-col",[a("b-form-input",{attrs:{placeholder:"Search Email or Subject"},on:{input:function(e){return t.$emit("search",e)}},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1),t._v(" "),a("b-col",[a("app-date-range-picker",{model:{value:t.dateRange,callback:function(e){t.dateRange=e},expression:"dateRange"}})],1),t._v(" "),a("b-col",[a("b-form-select",{attrs:{options:t.eventOptions},model:{value:t.eventSelected,callback:function(e){t.eventSelected=e},expression:"eventSelected"}})],1),t._v(" "),a("b-col",[a("b-button",{attrs:{variant:"outline-primary"},on:{click:function(e){return t.$emit("reload")}}},[a("i",{staticClass:"fas fa-search"}),t._v(" Search")]),t._v(" "),a("app-export-btn",{attrs:{"start-date":t.dateRange.startDate,"end-date":t.dateRange.endDate,search:t.search,"event-selected":t.eventSelected}}),t._v(" "),a("b-button",{directives:[{name:"b-tooltip",rawName:"v-b-tooltip.hover",modifiers:{hover:!0}}],attrs:{title:"Clear filters",variant:"outline-secondary"},on:{click:t.clear}},[a("i",{staticClass:"fas fa-times"})])],1)],1)};D._withStripped=!0;var k=a(6253),y=a(725),x=a(5531),C=a(8300),S=a(387),R=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-dropdown",{attrs:{variant:"outline-secondary",right:""},scopedSlots:t._u([{key:"button-content",fn:function(){return[a("i",{staticClass:"fas fa-download"})]},proxy:!0}])},[t._v(" "),a("b-dropdown-item",{attrs:{href:t.exportExcelUrl}},[a("i",{staticClass:"fas fa-file-excel"}),t._v(" Excel")]),t._v(" "),a("b-dropdown-item",{attrs:{href:t.exportCsvUrl}},[a("i",{staticClass:"fas fa-file-csv"}),t._v(" CSV")])],1)};R._withStripped=!0;a(5268),a(3710),a(1539),a(9714),a(6992),a(8783),a(3948),a(285);var O=a(5189),z=a(7379);const B={name:"app-export-btn",props:["startDate","endDate","search","eventSelected"],components:{BDropdown:O.R,BDropdownItem:z.E},data:function(){return{exportBaseUrl:window.APP_EXPORT_URL}},computed:{exportUrl:function(){var t={dateFrom:this.startDate.toISOString(),dateTo:this.endDate.toISOString()};return this.search.length&&(t.search=this.search),this.eventSelected&&(t.eventType=this.eventSelected),this.exportBaseUrl+"?"+new URLSearchParams(t).toString()},exportExcelUrl:function(){return this.exportUrl+"&format=excel"},exportCsvUrl:function(){return this.exportUrl+"&format=csv"}}};var E=(0,_.Z)(B,R,[],!1,null,null,null);E.options.__file="assets/js/App/Components/Activity/ExportBtn.vue";const P={name:"FilterForm",components:{AppExportBtn:E.exports,AppDateRangePicker:S.Z,BRow:k.T,BCol:y.l,BButton:h.T,BFormInput:x.e,BFormSelect:C.K},data:function(){return{search:"",dateRange:{startDate:p()().locale(window.navigator.language).startOf("week").utc().toDate(),endDate:p()().locale(window.navigator.language).endOf("week").utc().toDate()},eventSelected:null,eventOptions:[{value:null,text:"Select an event"},{value:"send",text:"Send"},{value:"delivery",text:"Delivery"},{value:"reject",text:"Reject"},{value:"bounce",text:"Bounce"},{value:"complaint",text:"Complaint"},{value:"failure",text:"Failure"},{value:"open",text:"Open"},{value:"click",text:"Click"}],exportBaseUrl:window.APP_EXPORT_URL}},methods:{clear:function(){this.search="",this.$emit("search",""),this.$emit("date-from",""),this.$emit("date-to",""),this.$emit("reload")}},watch:{dateRange:function(){this.$emit("date-from",this.dateRange.startDate),this.$emit("date-to",this.dateRange.endDate)},eventSelected:function(){this.$emit("event-selected",this.eventSelected)}},mounted:function(){this.$emit("date-from",this.dateRange.startDate),this.$emit("date-to",this.dateRange.endDate)}};var T=(0,_.Z)(P,D,[],!1,null,null,null);T.options.__file="assets/js/App/Components/Activity/FilterForm.vue";const A={name:"ActivityApp",components:{appFilterForm:T.exports,appEmailDetails:b},data:function(){return{isBusy:!1,showDetails:!1,detailsLoading:!1,emailDetails:null,selectedId:null,rows:[],search:"",dateFrom:"",dateTo:"",eventSelected:null,fields:[{key:"status",label:"Status"},{key:"subject",label:"Message"},{key:"timestamp",label:"Sent at"},{key:"opens",label:"Opens"},{key:"clicks",label:"Clicks"}],currentPage:1,perPage:10,totalRows:0}},methods:{loadData:function(){var t=this;t.isBusy=!0,u().get("/activity/list/api",{params:{page:this.currentPage,limit:this.perPage,search:this.search,dateFrom:p()(this.dateFrom).startOf("day").utc().toDate(),dateTo:p()(this.dateTo).endOf("day").utc().toDate(),eventType:this.eventSelected}}).then((function(e){t.rows=e.data.rows,t.totalRows=e.data.totalRows,t.isBusy=!1})).catch((function(e){t.isBusy=!1})).then((function(){t.isBusy=!1}))},rowClicked:function(t,e){this.showDetails=!0,this.selectedId=t.id}},watch:{currentPage:function(){this.loadData()}},filters:{formatDate:function(t){return t?p()(t).locale(window.navigator.language).local().format("LLL"):""}},mounted:function(){this.loadData()}};var L=(0,_.Z)(A,c,[],!1,null,null,null);L.options.__file="assets/js/App/ActivityApp.vue";const $=L.exports;s.Z.use(n.lF),s.Z.use(i.F),s.Z.use(o.s),s.Z.use(l.k),s.Z.use(r.i),new s.Z({el:"#app",render:function(t){return t($)}})},6700:(t,e,a)=>{var s={"./af":2786,"./af.js":2786,"./ar":867,"./ar-dz":4130,"./ar-dz.js":4130,"./ar-kw":6135,"./ar-kw.js":6135,"./ar-ly":6440,"./ar-ly.js":6440,"./ar-ma":7702,"./ar-ma.js":7702,"./ar-sa":6040,"./ar-sa.js":6040,"./ar-tn":7100,"./ar-tn.js":7100,"./ar.js":867,"./az":1083,"./az.js":1083,"./be":9808,"./be.js":9808,"./bg":8338,"./bg.js":8338,"./bm":7438,"./bm.js":7438,"./bn":8905,"./bn-bd":6225,"./bn-bd.js":6225,"./bn.js":8905,"./bo":1560,"./bo.js":1560,"./br":1278,"./br.js":1278,"./bs":622,"./bs.js":622,"./ca":2468,"./ca.js":2468,"./cs":5822,"./cs.js":5822,"./cv":877,"./cv.js":877,"./cy":7373,"./cy.js":7373,"./da":4780,"./da.js":4780,"./de":9740,"./de-at":217,"./de-at.js":217,"./de-ch":894,"./de-ch.js":894,"./de.js":9740,"./dv":5300,"./dv.js":5300,"./el":837,"./el.js":837,"./en-au":8348,"./en-au.js":8348,"./en-ca":7925,"./en-ca.js":7925,"./en-gb":2243,"./en-gb.js":2243,"./en-ie":6436,"./en-ie.js":6436,"./en-il":7207,"./en-il.js":7207,"./en-in":4175,"./en-in.js":4175,"./en-nz":6319,"./en-nz.js":6319,"./en-sg":1662,"./en-sg.js":1662,"./eo":2915,"./eo.js":2915,"./es":7093,"./es-do":5251,"./es-do.js":5251,"./es-mx":6112,"./es-mx.js":6112,"./es-us":1146,"./es-us.js":1146,"./es.js":7093,"./et":5603,"./et.js":5603,"./eu":7763,"./eu.js":7763,"./fa":6959,"./fa.js":6959,"./fi":1897,"./fi.js":1897,"./fil":2549,"./fil.js":2549,"./fo":4694,"./fo.js":4694,"./fr":4470,"./fr-ca":3049,"./fr-ca.js":3049,"./fr-ch":2330,"./fr-ch.js":2330,"./fr.js":4470,"./fy":5044,"./fy.js":5044,"./ga":9295,"./ga.js":9295,"./gd":2101,"./gd.js":2101,"./gl":8794,"./gl.js":8794,"./gom-deva":7884,"./gom-deva.js":7884,"./gom-latn":3168,"./gom-latn.js":3168,"./gu":5349,"./gu.js":5349,"./he":4206,"./he.js":4206,"./hi":94,"./hi.js":94,"./hr":316,"./hr.js":316,"./hu":2138,"./hu.js":2138,"./hy-am":1423,"./hy-am.js":1423,"./id":9218,"./id.js":9218,"./is":135,"./is.js":135,"./it":626,"./it-ch":150,"./it-ch.js":150,"./it.js":626,"./ja":9183,"./ja.js":9183,"./jv":4286,"./jv.js":4286,"./ka":2105,"./ka.js":2105,"./kk":7772,"./kk.js":7772,"./km":8758,"./km.js":8758,"./kn":9282,"./kn.js":9282,"./ko":3730,"./ko.js":3730,"./ku":1408,"./ku.js":1408,"./ky":3291,"./ky.js":3291,"./lb":6841,"./lb.js":6841,"./lo":5466,"./lo.js":5466,"./lt":7010,"./lt.js":7010,"./lv":7595,"./lv.js":7595,"./me":9861,"./me.js":9861,"./mi":5493,"./mi.js":5493,"./mk":5966,"./mk.js":5966,"./ml":7341,"./ml.js":7341,"./mn":5115,"./mn.js":5115,"./mr":370,"./mr.js":370,"./ms":9847,"./ms-my":1237,"./ms-my.js":1237,"./ms.js":9847,"./mt":2126,"./mt.js":2126,"./my":6165,"./my.js":6165,"./nb":4924,"./nb.js":4924,"./ne":6744,"./ne.js":6744,"./nl":3901,"./nl-be":9814,"./nl-be.js":9814,"./nl.js":3901,"./nn":3877,"./nn.js":3877,"./oc-lnc":2135,"./oc-lnc.js":2135,"./pa-in":5858,"./pa-in.js":5858,"./pl":4495,"./pl.js":4495,"./pt":9520,"./pt-br":7971,"./pt-br.js":7971,"./pt.js":9520,"./ro":6459,"./ro.js":6459,"./ru":238,"./ru.js":238,"./sd":950,"./sd.js":950,"./se":490,"./se.js":490,"./si":124,"./si.js":124,"./sk":4249,"./sk.js":4249,"./sl":4985,"./sl.js":4985,"./sq":1104,"./sq.js":1104,"./sr":9131,"./sr-cyrl":9915,"./sr-cyrl.js":9915,"./sr.js":9131,"./ss":5893,"./ss.js":5893,"./sv":8760,"./sv.js":8760,"./sw":1172,"./sw.js":1172,"./ta":7333,"./ta.js":7333,"./te":3110,"./te.js":3110,"./tet":2095,"./tet.js":2095,"./tg":7321,"./tg.js":7321,"./th":9041,"./th.js":9041,"./tk":9005,"./tk.js":9005,"./tl-ph":5768,"./tl-ph.js":5768,"./tlh":9444,"./tlh.js":9444,"./tr":2397,"./tr.js":2397,"./tzl":8254,"./tzl.js":8254,"./tzm":1106,"./tzm-latn":699,"./tzm-latn.js":699,"./tzm.js":1106,"./ug-cn":9288,"./ug-cn.js":9288,"./uk":7691,"./uk.js":7691,"./ur":3795,"./ur.js":3795,"./uz":6791,"./uz-latn":588,"./uz-latn.js":588,"./uz.js":6791,"./vi":5666,"./vi.js":5666,"./x-pseudo":4378,"./x-pseudo.js":4378,"./yo":5805,"./yo.js":5805,"./zh-cn":3839,"./zh-cn.js":3839,"./zh-hk":5726,"./zh-hk.js":5726,"./zh-mo":9807,"./zh-mo.js":9807,"./zh-tw":4152,"./zh-tw.js":4152};function n(t){var e=i(t);return a(e)}function i(t){if(!a.o(s,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return s[t]}n.keys=function(){return Object.keys(s)},n.resolve=i,t.exports=n,n.id=6700},387:(t,e,a)=>{"use strict";a.d(e,{Z:()=>c});var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("date-range-picker",{ref:"picker",attrs:{opens:"right",autoApply:!0,ranges:t.ranges,"locale-data":{firstDay:t.firstDayOfWeek}},on:{update:t.update},scopedSlots:t._u([{key:"input",fn:function(e){return[a("i",{staticClass:"fa fa-calendar-alt"}),t._v(" "+t._s(t._f("date")(e.startDate))+" - "+t._s(t._f("date")(e.endDate))+"\n  ")]}}]),model:{value:t.dateRange,callback:function(e){t.dateRange=e},expression:"dateRange"}})};s._withStripped=!0;var n=a(381),i=a.n(n),o=a(7144);const l={name:"AppDateRangePicker",components:{DateRangePicker:a.n(o)()},props:["value"],data:function(){return{dateRange:this.value,ranges:{Today:[i()().locale(window.navigator.language).startOf("day").toDate(),i()().locale(window.navigator.language).endOf("day").toDate()],Yesterday:[i()().locale(window.navigator.language).startOf("day").subtract(1,"days").toDate(),i()().locale(window.navigator.language).endOf("day").subtract(1,"days").toDate()],"This week":[i()().locale(window.navigator.language).startOf("week").toDate(),i()().locale(window.navigator.language).endOf("week").toDate()],"Last week":[i()().locale(window.navigator.language).subtract(1,"weeks").startOf("week").toDate(),i()().locale(window.navigator.language).subtract(1,"weeks").endOf("week").toDate()],"This month":[i()().locale(window.navigator.language).startOf("month").toDate(),i()().locale(window.navigator.language).endOf("month").toDate()],"Last month":[i()().locale(window.navigator.language).subtract(1,"months").startOf("month").toDate(),i()().locale(window.navigator.language).subtract(1,"months").endOf("month").toDate()]}}},filters:{date:function(t){return i()(t).locale(window.navigator.language).format("YYYY-MM-DD")}},computed:{firstDayOfWeek:function(){return i().localeData(window.navigator.language).firstDayOfWeek()}},methods:{update:function(){this.$emit("input",{startDate:this.dateRange.startDate,endDate:this.dateRange.endDate})}}};var r=(0,a(1900).Z)(l,s,[],!1,null,null,null);r.options.__file="assets/js/App/Components/Common/AppDateRangePicker.vue";const c=r.exports}},t=>{t.O(0,[833,737],(()=>{return e=6093,t(t.s=e);var e}));t.O()}]);