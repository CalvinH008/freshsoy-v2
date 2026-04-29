import "./bootstrap";
import "./pos.js";
import Alpine from "alpinejs";
import { productForm } from "./pos.js";

Alpine.data("productForm", productForm);
window.Alpine = Alpine;
Alpine.start();
