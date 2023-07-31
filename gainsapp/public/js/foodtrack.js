import {app,auth,firebase} from "./app.js";

var uid = getCookie("uid");
if (uid) {
  // User is signed in, do something
  console.log(uid);
  console.log(firebase);
  console.log(app);
} else {
  // User is not signed in, do something else
  console.log(rip);
}

// Function to get a cookie by name
function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}


const apiKey = '9y4tKjBbVQQZxR7FGpABHGDSVvCeMcyoZjQ4yLK5';


const searchForm = document.getElementById('search-form');
const resultsTable = document.getElementById('results-table');
const resultsTxt = document.getElementById('results-txt');
const selectedFoodsList = document.querySelector('#selected-foods tbody');
const foodListTxt = document.getElementById('food-list-txt');

searchForm.addEventListener('input', (event) => {
  event.preventDefault();
  const foodName = document.getElementById('food-name').value;
  searchFood(foodName);
  resultsTxt.innerHTML="";
});

function searchFood(foodName) {
  fetch(`https://api.nal.usda.gov/fdc/v1/search?api_key=${apiKey}&generalSearchInput=${foodName}`)
    .then(response => response.json())
    .then(data => {
      displayResults(data.foods);
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
}

function displayResults(foods) {
  const tableBody = resultsTable.querySelector('tbody');
  tableBody.innerHTML = '';
  foods.forEach(food => {
    const row = document.createElement('tr');
    const nameCell = document.createElement('td');
    nameCell.textContent = food.description;
	const servingSizeCell = document.createElement('td');
	servingSizeCell.textContent = food.servingSize ? (food.servingSize + food.servingSizeUnit) : '1 Portion'  ;
	row.appendChild(nameCell);
	row.appendChild(servingSizeCell);
    tableBody.appendChild(row);

	row.addEventListener('click', () => {
      addFoodToList(food);
	  foodListTxt.innerHTML="";
	  foodListTxt.classList.remove("food-list-container")
    });
  });
}

const nutrientList = [0,0,0];
var xValues = ["Protein", "Carbs", "Fat"];

var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797"
];

const nutrientChart = new Chart("food-chart", {
	type: "doughnut",
	data: {
		labels: xValues,
		datasets: [{
		backgroundColor: barColors,
		data: nutrientList
		}]
	},
	options: {
		title: {
		display: true,
		text: "World Wide Wine Production"
		}
	}
});

let calories = 0;


function addFoodToList(food) {
	for (let i = 0; i < food.foodNutrients.length; i++) {
		let nutrients = food.foodNutrients[i];
		if (nutrients.nutrientId === 1003) { // protein
			nutrientList[0] += nutrients.value;
		} else if (nutrients.nutrientId === 1005) { // carbs
			nutrientList[1] += nutrients.value;
		} else if (nutrients.nutrientId === 1004) { // fat
			nutrientList[2] += nutrients.value;
		} else if (nutrients.nutrientId === 1008) { // energy
			calories = nutrients.value;
		}	
	}

	console.log(nutrientList);	
	console.log(food.foodNutrients);

	// create a new row for the table
	const row = document.createElement("tr");

	// create table cells for each property
	const nameCell = document.createElement("td");
	nameCell.textContent = food.description;
	row.appendChild(nameCell);

	const servingSizeCell = document.createElement("td");
	servingSizeCell.textContent = food.servingSize ? `${food.servingSize} ${food.servingSizeUnit ? food.servingSizeUnit : 'serving'}` : '1 serving';
	row.appendChild(servingSizeCell);

	const caloriesCell = document.createElement("td");
	
	caloriesCell.textContent = calories ? `${calories} calories` : 'calories not available';;
	row.appendChild(caloriesCell);

	// append the row to the table body
	
	selectedFoodsList.appendChild(row);
	nutrientChart.update();
	/*
	const db = firebase.database();

	app.database.ref("users/"+ uid).set({
		Protein:nutrientList[0],
		Carbs:nutrientList[0],
		Fat:nutrientList[0]
	});
	*/
}

