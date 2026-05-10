import "./bootstrap";
import "./pos.js";
import Alpine from "alpinejs";
import { posSystem, productForm } from "./pos.js";

Alpine.data("productForm", productForm);
Alpine.data("posSystem", posSystem);
window.Alpine = Alpine;
Alpine.start();
