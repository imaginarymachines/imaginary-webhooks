const ACTIONS = {
	addClass: {
		prompts: [
			{
				type: "input",
				name: "name",
				message: "class name",
			},
		],
		actions: [
			{
				type: "add",
				path: "php/{{camelCase name}}.php",
				templateFile: "plop-templates/Class.hbs",
			},
		],
	},
};
const plops = {
	phpClass(plop) {
		plop.setGenerator("class", {
			description: "Add a php class",
			...ACTIONS.addClass,
		});
	},
	event(plop) {
		plop.setGenerator("event", {
			description: "application controller logic",
			prompts: [
				ACTIONS.addClass.prompts[0],
				//id
				{
					type: "input",
					name: "id",
					message: "slug case unique id for event",
				},
				//Title
				{
					type: "input",
					name: "title",
					message: "Label for event",
				},
				//Hook name
				{
					type: "input",
					name: "hook",
					message: "WordPress hook name",
				},
			],
			actions: [
				{
					type: "add",
					path: "php/Events/{{camelCase name}}.php",
					templateFile: "plop-templates/Event.hbs",
				},
			],
		});
	},
	endpoint(plop) {
		// controller generator
		plop.setGenerator("endpoint", {
			description: "application controller logic",
			prompts: [
				ACTIONS.addClass.prompts[0],
				{
					type: "input",
					name: "route",
					message: "endpoint",
				},
			],
			actions: [
				{
					type: "add",
					path: "php/Endpoints/{{camelCase name}}.php",
					templateFile: "plop-templates/Endpoint.hbs",
				},
			],
		});
	},
};
module.exports = function (plop) {
	//To uppercase
	plop.setHelper("upperCase", function (text) {
		return text.toUpperCase();
	});
	//To CamelCase
	plop.setHelper("camelCase", function (text) {
		return (
			text.substring(0, 1).toUpperCase() +
			text
				.substring(1)
				.replace(/(?:^\w|[A-Z]|\b\w)/g, function (word, index) {
					return index === 0 ? word.toLowerCase() : word.toUpperCase();
				})
				.replace(/\s+/g, "")
		);
	});
	plops.phpClass(plop);
	plops.event(plop);
	plops.endpoint(plop);
};
