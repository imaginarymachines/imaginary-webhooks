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
	addInterface: {
		prompts: [
			{
				type: "input",
				name: "name",
				message: "interface name",
			},
		],
		actions: [
			{
				type: "add",
				path: "php/Contracts/{{camelCase name}}.php",
				templateFile: "plop-templates/Interface.hbs",
			},
		],
	},
	addMetabox: {
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
				path: "php/Metaboxes/{{camelCase name}}.php",
				templateFile: "plop-templates/Metabox.hbs",
			},
		],
	},
};
const GENERATORS = [
	function phpClass(plop) {
		plop.setGenerator("class", {
			description: "Add a php class",
			...ACTIONS.addClass,
		});
	},
	function event(plop) {
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
	function endpoint(plop) {
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
	function addInterface(plop) {
		plop.setGenerator("interface", {
			description: "Add a php interface",
			...ACTIONS.addInterface,
		});
	},
	//Metabox
	function (plop) {
		plop.setGenerator("metabox", {
			description: "Add a post editor metabox",
			...ACTIONS.addMetabox,
		});
	}
];
const PARTIALS = [
	//Link to WordPress reference for a class
	//Usage: {{> wpDocsClass }}
	function (plop) {
		plop.setPartial('wpDocsClass', '@see https://developer.wordpress.org/reference/classes/{{class}}/');
	},
	//Link to WordPress reference for a function
	//Usage: {{> wpDocsFunction }}
	function (plop) {
		plop.setPartial('wpDocsFunction', '@see https://developer.wordpress.org/reference/functions/{{function}}/');
	},
	//Link to WordPress reference for a hook
	//Usage: {{> wpDocsHook }}
	function (plop) {
		plop.setPartial('wpDocsHook', '@see https://developer.wordpress.org/reference/hooks/{{hook}}/');
	},
];
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
	GENERATORS.forEach(generator => generator(plop));
	PARTIALS.forEach(partial => partial(plop));
};
