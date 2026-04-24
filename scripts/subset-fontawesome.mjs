// Generates a Font Awesome subset CSS containing only the icons used in resources/views.
// Usage: node scripts/subset-fontawesome.mjs
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');
const srcCss = path.join(root, 'public/vendor/font-awesome/css/all.min.css');
const outCss = path.join(root, 'public/vendor/font-awesome/css/subset.min.css');
const viewsDir = path.join(root, 'resources/views');

// Recursively collect .blade.php files
function walk(dir, files = []) {
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const full = path.join(dir, entry.name);
        if (entry.isDirectory()) walk(full, files);
        else if (entry.name.endsWith('.blade.php')) files.push(full);
    }
    return files;
}

// Extract every "fa-xxx" token used in views (after a fas/far/fab/fa class)
const iconRegex = /\bfa-([a-z0-9-]+)\b/g;
const skipTokens = new Set(['fw', 'lg', 'xs', 'sm', 'spin', 'pulse', 'border', 'pull-left', 'pull-right', 'rotate-90', 'rotate-180', 'rotate-270', 'flip-horizontal', 'flip-vertical', '2x', '3x', '4x', '5x', '6x', '7x', '8x', '9x', '10x']);
const used = new Set();
for (const file of walk(viewsDir)) {
    const content = fs.readFileSync(file, 'utf8');
    let m;
    while ((m = iconRegex.exec(content)) !== null) {
        const name = m[1];
        if (!skipTokens.has(name) && !/^\d/.test(name)) used.add(name);
    }
}

console.log(`Found ${used.size} unique icon tokens in views.`);

const css = fs.readFileSync(srcCss, 'utf8');

// Find the cut point: where individual icon rules start.
// Pattern: ".fa-NAME:before{content:\"\\fXXX\"}" (these are the bulky rules)
// We'll keep everything before the first such rule, then only keep matching ones.
const firstIconMatch = css.match(/\.fa-[a-z0-9-]+:before\{content:"\\[a-f0-9]+"\}/i);
if (!firstIconMatch) {
    console.error('Could not detect icon block start.');
    process.exit(1);
}
const cutIndex = firstIconMatch.index;
const prefix = css.slice(0, cutIndex);
const iconsBlock = css.slice(cutIndex);

// Match all icon-rule selectors (handles grouped selectors like ".fa-a,.fa-b:before{content:..}")
const ruleRegex = /(\.fa-[a-z0-9-]+(?:[:,][^{]*)?)\{content:"\\[a-f0-9]+"\}/gi;
let kept = 0;
let dropped = 0;
const filtered = iconsBlock.replace(/\.fa-([a-z0-9-]+):before\{content:"\\([a-f0-9]+)"\}/gi, (full, name) => {
    if (used.has(name)) {
        kept++;
        return full;
    }
    dropped++;
    return '';
});

const output = prefix + filtered + '\n';
fs.writeFileSync(outCss, output, 'utf8');

const before = fs.statSync(srcCss).size;
const after = fs.statSync(outCss).size;
console.log(`Kept ${kept} icon rules, dropped ${dropped}.`);
console.log(`Original: ${before} bytes -> Subset: ${after} bytes (${Math.round((1 - after / before) * 100)}% smaller).`);
console.log(`Wrote: ${outCss}`);

// Sanity check: verify each used icon is present
const missing = [];
for (const name of used) {
    if (!new RegExp(`\\.fa-${name}:before\\{`).test(output) && !new RegExp(`\\.fa-${name}\\b`).test(output)) {
        missing.push(name);
    }
}
if (missing.length) {
    console.warn('WARNING: icons referenced in views but not found in CSS:', missing.join(', '));
}
