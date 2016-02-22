"use strict";

function run(path) {
    if (BABYLON.Engine.isSupported()) {

        //BABYLON.Engine.ShadersRepository = "/Babylon/Shaders/";

        var canvas = document.getElementById("renderCanvas");
        var engine = new BABYLON.Engine(canvas, false);

        // Resize
        window.addEventListener("resize", function () {
            engine.resize();
        });

        // Scene, light and camera
        var scene = new BABYLON.Scene(engine);
        var light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(0, 1, 0), scene);
		//light.diffuse = new BABYLON.Color3(1, 1, 1);
		//light.specular = new BABYLON.Color3(1, 1, 1);
		//light.groundColor = new BABYLON.Color3(0, 0, 0);
		//var light = new BABYLON.PointLight("Omni", new BABYLON.Vector3(20, 20, 100), scene);
        var camera = new BABYLON.ArcRotateCamera("Camera", 0, 0, 0, new BABYLON.Vector3(0, 0, 0), scene);
		camera.setPosition(new BABYLON.Vector3(0, 0, -300));
		camera.attachControl(canvas);

        // Assets manager
        var assetsManager = new BABYLON.AssetsManager(scene);

        var meshTask = assetsManager.addMeshTask("man task", "", path+"/assets/", "man.txt");

        // You can handle success and error on a per-task basis (onSuccess, onError)
        meshTask.onSuccess = function (task) {
            //task.loadedMeshes[0].position = new BABYLON.Vector3(0, 0, 0);
			//alert(scene.getMeshByName("H_DDS_CrowdRes pSphere3"));
			
			//scene.getMeshByName("H_DDS_CrowdRes").material.alpha = 0.3;
			scene.getMeshByName("Anahata").material = new BABYLON.StandardMaterial("texture1", scene);
			scene.getMeshByName("Anahata").material.alpha = 0.3;
			
			var aura = BABYLON.Mesh.CreateSphere("sphere1", 16, 120, scene);
			aura.material = new BABYLON.StandardMaterial("texture1", scene);
			aura.material.alpha = 0.3;
			aura.material.emissiveColor = new BABYLON.Color3(1, .2, .7);
			aura.material.specularColor = new BABYLON.Color3(0.1, 0.1, 0.8);
			aura.scaling.y = 1.8;
			
			//sphere.position = scene.getMeshByName("pSphere8").position;
			
			var particleSystem = new BABYLON.ParticleSystem("particles", 2000, scene);
			particleSystem.particleTexture = new BABYLON.Texture(path+"/assets/Flare.png", scene);
			//particleSystem.textureMask = new BABYLON.Color4(0.8, 0.8, 0.1, 1.0);
			particleSystem.emitter = scene.getMeshByName("Adjna");
			particleSystem.emitRate = 100;
			particleSystem.minLifeTime = 3;
			particleSystem.maxLifeTime = 4;
			particleSystem.minSize = 0.1;
			particleSystem.maxSize = 1;
			particleSystem.gravity = new BABYLON.Vector3(0, 0, -10);
			particleSystem.direction1 = new BABYLON.Vector3(-7, 8, 3);
			particleSystem.direction2 = new BABYLON.Vector3(7, 8, -3);
			particleSystem.minAngularSpeed = 0;
			particleSystem.maxAngularSpeed = Math.PI;
			particleSystem.start();
        }

        // But you can also do it on the assets manager itself (onTaskSuccess, onTaskError)
        assetsManager.onTaskError = function (task) {
            console.log("error while loading " + task.name);
        }


		scene.registerBeforeRender(function () {
                //light.position = camera.position;
            });
			
		//newMeshes[5].position.x = -100;
		//scene.debugLayer.show();
		//var sphere = BABYLON.Mesh.CreateSphere("sphere1", 160, 200, scene);

        assetsManager.onFinish = function (tasks) {
            engine.runRenderLoop(function () {
                scene.render(); 
            });
        };


        // Can now change loading background color:
        engine.loadingUIBackgroundColor = "Purple";

        // Just call load to initiate the loading sequence
        assetsManager.load();
    }
};