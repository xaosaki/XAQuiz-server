
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});

require('./quizTemplate');
require('./answer');

const Chart = require('chart.js');
require('./Chart.PieceLabel.min');


const chartHolder = document.querySelector('.js-result-chart');
if(chartHolder){
	var correct = chartHolder.getAttribute('data-correct');
	var fail = 100 - correct;
	var data = {
		datasets: [{
			data: [correct, fail],
			backgroundColor: [
				'rgba(178, 245, 178, 0.9)',
				'rgba(245, 178, 178, 0.9)'
			]
		}],
		labels: ['Верно', 'Не верно']

		// These labels appear in the legend and in the tooltips when hovering different arcs
	};
	var myPieChart = new Chart(chartHolder,{
		type: 'pie',
		data: data,
		options: {
			legend: {
				display: false
			},
			pieceLabel: {
				render: 'percentage',
				precision: 0
			}
		}
	});
}

