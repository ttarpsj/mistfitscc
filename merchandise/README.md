# Product catalog

The shop reads `products.json` in this directory. The older individual JSON files are retained for reference and are not loaded by the shop. Product prices are numeric USD amounts; all current products are sold out.

Put numbered product photos in `public/images/product-N/`, named `product-N-001.png`, `product-N-002.webp`, and so on. They are discovered in numerical order. A `product-chart.png`, `.webp`, or `.jpg` in the same folder appears separately in the size guide. Do not include unverified specifications in public-facing fields.

Run `npm run build` and `php scripts/export-static.php` to regenerate the GitHub Pages site after changes.
