<html>

<head>
    <meta charset="utf-8">
    <title>PesanBungkus Leaderboards</title>
    <meta name="viewport" content="width=device-width, user-scalable=0, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    
    <link href="css/style.css" rel="stylesheet">
    <style>
    .fade-enter, .fade-leave-active {
		opacity: 0;
    }

    .fade-enter-active, .fade-leave-active {
		transition: opacity .25s;
    }

	#timer {
		font-family: Arial, sans-serif;
		font-size: 20px;
		color: #999;
		letter-spacing: -1px;
	}
	#timer span {
		font-size: 40px;
		color: #333;
		margin: 0 3px 0 15px;
	}
	#timer span:first-child {
		margin-left: 0;
	}
  

    </style>
</head>

<body style="background: white !important;">
	<aside></aside>

    <main id="app" style="background: white !important;">
        <transition name="fade" mode="out-in">
			<keep-alive>
				<component :is="$store.getters.currentTab" /> </component>
			</keep-alive>
		</transition>

        <transition name="fade" mode="out-in">
            <component is="Footer" />
            </component>
        </transition>
    </main>
	
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vuex/2.0.0/vuex.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.js"></script>

	<script type="text/x-template" id="Header">
		<div class="header-page">
			<h1>PesanBungkus Leaderboards</h1>
			<h4 id="leaderboard-type-caption">Weekly Top Players <br> <small>Diamond Rank</small></h4>
		</div>
	</script>

	<script type="text/x-template" id="Footer">
		<div id="footer" style="color: #1b9cfc !important;">
			<p>© copyright <b>PesanBungkus</b> 2018.</p>
		</div>
	</script>

	<script type="text/x-template" id="MenuTop">
		<div id="menu-top" style=" position: inherit;">
			<div style="background: rgb(82, 168, 246);">
				<ul>
					<li @click="$store.dispatch('onChangeTab', {tab: 'Diamond'}); onTabDiamond();"
						style="width: 19% !important;" 
						id="menu-diamond-rank-button" 
						v-pointer
						class="">
						<div><span></span> Diamond</div>
					</li>
					<li @click="$store.dispatch('onChangeTab', {tab: 'Platinum'}); onTabPlatinum();"
						style="width: 19% !important;" 
						id="menu-platinum-rank-button" 
						v-pointer
						class="">
						<div><span></span> Platinum</div>
					</li>
					<li @click="$store.dispatch('onChangeTab', {tab: 'Gold'}); onTabGold();"
						style="width: 19% !important;" 
						id="menu-gold-rank-button" 
						v-pointer
						class="">
						<div><span></span> Gold</div>
					</li>
					<li @click="$store.dispatch('onChangeTab', {tab: 'Silver'}); onTabSilver();"
						style="width: 19% !important;" 
						id="menu-silver-rank-button" 
						v-pointer
						class="">
						<div><span></span> Silver</div>
					</li>
					<li @click="$store.dispatch('onChangeTab', {tab: 'Bronze'}); onTabBronze();"
						style="width: 19% !important;" 
						id="menu-bronze-rank-button" 
						v-pointer
						class="active">
						<div><span></span> Bronze</div>
					</li>
				</ul>
			</div>
		</div>
	</script>

	<script type="text/x-template" id="TableView">
		<div id="leaderboard-wrapper">
			<div id="leaderboard-wrapper-nav">
				<ul style="background: rgb(172, 250, 255) !important;">
					<li id="leaderboard-top-score-button" 
						style="width: calc(100% - 20px)  !important; color: #3950ac;"
						class="">{{ $title }} - @{{ $store.getters.currentTab }} ( {{ $tournament->day_begin }} - {{ $tournament->day_end }} )
						@if($path == 'tournament')
							<br>
							<div id="timer" v-if="!$store.getters.getTimeup">
								<span id="days">@{{ $store.getters.getDays }}</span> Hari
								<span id="hours">@{{ $store.getters.getHours }}</span> Jam
								<span id="minutes">@{{ $store.getters.getMinutes }}</span> Menit
								<span id="seconds">@{{ $store.getters.getSeconds }}</span> Detik
							</div>

								<!-- <a style="font-size: 14px; color: black; font-weight: 100;">
									Waktu Mulai: {{ $tournament->day_begin }} s/d
									Waktu Selesai: {{ $tournament->day_end }} 
								</a>    -->
						@endif
					</li>
				</ul>
			</div>
			<menu-top></menu-top>
			<div id="leaderboard-wrapper-main">
				<div id="leaderborad-top-score-wrapper">
					<table id="leaderboard-top-score-table" class="show">
						<tbody>
							<slot />
						</tbody>
					</table>                    
				</div>
			</div>
		</div>
	</script>

	<script type="text/x-template" id="TopScore">
		<TableView>
			<tr v-for="(item, index) in payload" :key="index">
				<td><span>@{{ index + 1 }}</span></td>
				<td><b>@{{ item.get_user_profile.name }}</b></td>
				<td>@{{ item.score_tournament | ribuan }}</td>
			</tr>
			<kosong v-if="payloadLength <= 0" />
		</TableView>
	</script>

	<script type="text/x-template" id="Bronze">
		<TableView>
			<tr v-for="(item, index) in $store.getters.getPayload.bronze" :key="index">
				<td><span>@{{ index + 1 }}</span></td>
				<td><b>@{{ item.get_user_profile.name }}</b></td>
				<td>@{{ item.score_tournament | ribuan }}</td>
			</tr>				
			<kosong v-if="$store.getters.getLength('bronze') <= 0" />
		</TableView>
	</script>	
	
	<script type="text/x-template" id="Silver">
		<TableView>
			<tr v-for="(item, index) in $store.getters.getPayload.silver" :key="index">
				<td><span>@{{ index + 1 }}</span></td>
				<td><b>@{{ item.get_user_profile.name }}</b></td>
				<td>@{{ item.score_tournament | ribuan }}</td>
			</tr>								
			<kosong v-if="$store.getters.getLength('silver') <= 0" />
		</TableView>
	</script>	
	
	<script type="text/x-template" id="Gold">
		<TableView>
			<tr v-for="(item, index) in $store.getters.getPayload.gold" :key="index">
				<td><span>@{{ index + 1 }}</span></td>
				<td><b>@{{ item.get_user_profile.name }}</b></td>
				<td>@{{ item.score_tournament | ribuan }}</td>
			</tr>			
			<kosong v-if="$store.getters.getLength('gold') <= 0" />
		</TableView>
	</script>		
	
	<script type="text/x-template" id="Platinum">
		<TableView>
			<tr v-for="(item, index) in $store.getters.getPayload.platinum" :key="index">
				<td><span>@{{ index + 1 }}</span></td>
				<td><b>@{{ item.get_user_profile.name }}</b></td>
				<td>@{{ item.score_tournament | ribuan }}</td>
			</tr>			
			<kosong v-if="$store.getters.getLength('platinum') <= 0" />
		</TableView>
	</script>			
	
	<script type="text/x-template" id="Diamond">
		<TableView>
			<tr v-for="(item, index) in $store.getters.getPayload.diamond" :key="index">
				<td><span>@{{ index + 1 }}</span></td>
				<td><b>@{{ item.get_user_profile.name }}</b></td>
				<td>@{{ item.score_tournament | ribuan }}</td>
			</tr>						
			<kosong v-if="$store.getters.getLength('diamond') <= 0" />
		</TableView>
	</script>			

	<script>
		function Manipulation(args){
			document.getElementById('menu-bronze-rank-button').className = args.bronze != undefined || args.bronze != null ? 'active' : '';
			document.getElementById('menu-silver-rank-button').className = args.silver != undefined || args.silver != null ? 'active' : '';
			document.getElementById('menu-gold-rank-button').className = args.gold != undefined || args.gold != null ? 'active' : '';
			document.getElementById('menu-platinum-rank-button').className = args.platinum != undefined || args.platinum != null ? 'active' : '';
			document.getElementById('menu-diamond-rank-button').className = args.diamond != undefined || args.diamond != null ? 'active' : '';
			
			// document.getElementById('leaderboard-top-score-button').className = args.score != undefined || args.score != null ? 'active' : '';
			// document.getElementById('leaderboard-top-player-button').className = args.player != undefined || args.player != null ? 'active' : '';			
		}
	
	
		Vue.filter('ribuan', function (value) {
			var reverse = value.toString().split('').reverse().join('')
			var ribuan = reverse.match(/\d{1,3}/g)
			return ribuan = ribuan.join('.').split('').reverse().join('');
		});

		Vue.directive('pointer', {
		  bind(element, binding, vnode) {
			element.style.cursor = "pointer" 
		  }
		})		
		
		Vue.component('MenuTop', {
			template: '#MenuTop',
			methods: {
				onTabBronze(){
					setTimeout(() => {
						Manipulation({ bronze: true })
					}, 500);
				},
				onTabSilver(){
					setTimeout(() => {
						Manipulation({ silver: true })
					}, 500);
				},
				onTabGold(){
					setTimeout(() => {
						Manipulation({ gold: true })
					}, 500);
				},
				onTabPlatinum(){
					setTimeout(() => {
						Manipulation({ platinum: true })
					}, 500);
				},
				onTabDiamond(){
					setTimeout(() => {
						Manipulation({ diamond: true })
					}, 500);
				},
			},			
		})
		
		Vue.component('Header', {
			template: '#Header',
		})

		Vue.component('Kosong', {
			template: `
			<tr>
				<td></td>
				<td colspan="2"><b>Data Kosong</b></td>
			</tr>	
			`
		})
		
		Vue.component('TopScore', {
			template: '#TopScore',
			data(){
				return {
					payload: null,
					payloadLength: 0,
				}
			},
			watch: {
				'$store.getters.getPayload': function(val) {
					this.payload = val.topscore
					this.payloadLength = val.topscore.length
				}
			},
		})
		
		Vue.component('Bronze', {
			template: '#Bronze',
		})
		
		Vue.component('Silver', {
			template: '#Silver',			
		})
		
		Vue.component('Gold', {
			template: '#Gold',		
		})
		
		Vue.component('Platinum', {
			template: '#Platinum',		
		})
		
		Vue.component('Diamond', {
			template: '#Diamond',		
		})
		
		Vue.component('TableView', {
			methods: {
				onTabTopScore(){
					setTimeout(() => {
						Manipulation({ score: true })
					}, 500);
				},
			},
			template: '#TableView',
		})

		Vue.component('Footer', {
			template: '#Footer'
		})

		const store = new Vuex.Store({
			state: {
				tab: 'Bronze',
				payload: [],

				days: 0,
				hours: 0,
				minutes: 0,
				seconds: 0,
				timeup: false,
			},
			getters: {
				currentTab(state) {
					return state.tab
				},
				getPayload(state) {
					console.log(state.payload)
					return state.payload
				},
				getLength(state){
					return function(args){
						return state.payload[args] == undefined ? 0 : state.payload[args].length
					}
				},
				getTimeup(state) {
					return state.timeup
				},
				getDays(state) {
					return state.days
				},
				getHours(state) {
					return state.hours
				},
				getMinutes(state) {
					return state.minutes
				},
				getSeconds(state) {
					return state.seconds
				},
			},
			mutations: {
				changeTab(state, payload) {
					state.tab = payload.tab;
				},
				setPayload(state, payload){
					state.payload = payload;
				},
			},
			actions: {
				onChangeTab(context, payload) {
					context.dispatch('onRequestData');
					context.commit('changeTab', payload)
				},
				onRequestData(context) {
					axios.get('{{ url("/api/leaderboard/all?path=tournament") }}')
					.then(function (response) {
						if(response.data.countdown == 0) {
							context.state.timeup = true
						} else {
							context.dispatch('onCountDown', response.data.countdown);
						}
						context.commit('setPayload', response.data.leaderboard)
						console.log(response.data);
					})
					.catch(function (error) {
						// handle error
						console.log(error);
					})
					.then(function () {
						// always executed
					});					
				},
				onCountDown(context, payload){
					var timer;

					var compareDate = new Date(payload);
					compareDate.setDate(compareDate.getDate() + 0); //just for this demo today + 7 days

					function timeBetweenDates(toDate) {
						var dateEntered = toDate;
						var now = new Date();
						var difference = dateEntered.getTime() - now.getTime();

						if (difference <= 0) {

							// Timer done
							clearInterval(timer);
						
						} else {
							
							var seconds = Math.floor(difference / 1000);
							var minutes = Math.floor(seconds / 60);
							var hours = Math.floor(minutes / 60);
							var days = Math.floor(hours / 24);

							hours %= 24;
							minutes %= 60;
							seconds %= 60;

							context.state.days = days
							context.state.hours = hours
							context.state.minutes = minutes
							context.state.seconds = seconds

							// console.log(seconds)
						}
					}				

					timer = setInterval(function() {
						timeBetweenDates(compareDate);
					}, 1000);					
				}				
			}
		})

		new Vue({
			el: '#app',
			store,
			mounted(){
				this.$store.dispatch('onRequestData');
			}			
		});
	</script>

</body>

</html>