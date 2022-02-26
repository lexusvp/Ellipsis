import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.121.1/build/three.module.js';
import { LineMaterial } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/lines/LineMaterial.js';
import { Wireframe } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/lines/Wireframe.js';
import { WireframeGeometry2 } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/lines/WireframeGeometry2.js';

let torus, torus2, renderer, scene, camera, material;
let insetWidth, insetHeight;

let initPos = 250;
let initRadius = 25;
let triggered = false;

export function homeAnim() {
   const main = document.querySelector("main");

   init();
   animate();

   setTimeout(() => {
      main.style.display = "block";
   }, 4600);
}

function init() {
   scene = new THREE.Scene();
   camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 1, 1000);
   renderer = new THREE.WebGLRenderer({  
      canvas: document.querySelector("#headerCtx"),
      antialias: true,
      alpha: true,
   });
   renderer.setSize(window.innerWidth, window.innerHeight);
   renderer.setPixelRatio(window.devicePixelRatio);
   camera.position.setZ(initPos);
   material = new LineMaterial({
      color: 0x3f3f3f,
      linewidth: 6,
      dashed: true
   });
   
   let geo = new THREE.TorusGeometry(initRadius, 5, 10, 60);
   const geometry = new WireframeGeometry2(geo);
   torus = new Wireframe(geometry, material);
   scene.add(torus);
   
   let geo2 = new THREE.TorusGeometry(12, 2, 4, 30);
   const geometry2 = new WireframeGeometry2(geo2);
   torus2 = new Wireframe(geometry2, material);
   
   
   scene.add(torus2);
   window.addEventListener('resize', onWindowResize);
   onWindowResize();

}
function animate() {
   requestAnimationFrame(animate);
   renderer.setViewport(0, 0, window.innerWidth, window.innerHeight);
   material.resolution.set(window.innerWidth, window.innerHeight); // resolution of the viewport
   torus.rotation.z += 0.002;
   

   if (initPos > 60) {
      initPos -= 0.5;
      camera.position.setZ(initPos);
   } if (torus.rotation.y < Math.PI * 2 && !triggered) {
      torus.rotation.y += 0.02;
      torus2.rotation.x += 0.02;
   } else{

      setTimeout(() => {
         if (initPos > 30) {
            initPos -= 0.1;
            camera.position.setZ(initPos);
         }
      }, 700);
      torus.rotation.z += 0.001;
      torus2.rotation.z -= 0.002;
   }


   renderer.render(scene, camera);
}
function onWindowResize() {
   camera.aspect = window.innerWidth / window.innerHeight;
   camera.updateProjectionMatrix();

   renderer.setSize(window.innerWidth, window.innerHeight);

   insetWidth = window.innerHeight / 4;
   insetHeight = window.innerHeight / 4;
}

