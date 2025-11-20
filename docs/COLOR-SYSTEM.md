# Color System

VILT Canvas uses a centralized HSL-based color system that provides consistent theming, easy customization, and full dark mode support.

## Overview

The color system is defined in `resources/css/app.css` using CSS custom properties (variables). It uses HSL (Hue, Saturation, Lightness) color format, which makes it easy to create color variations and maintain consistency.

## Color Architecture

### Primary Colors

The primary color is the main brand color. You only need to set three values, and all shades are automatically derived:

```css
--primary-h: 270;      /* Hue (0-360) */
--primary-s: 90%;      /* Saturation */
--primary-l: 55%;      /* Lightness (base 500) */
```

From these, all primary shades (50-900) are automatically calculated:

```css
--primary-50:  hsl(var(--primary-h) var(--primary-s) 97%);
--primary-100: hsl(var(--primary-h) var(--primary-s) 90%);
--primary-200: hsl(var(--primary-h) var(--primary-s) 80%);
--primary-300: hsl(var(--primary-h) var(--primary-s) 70%);
--primary-400: hsl(var(--primary-h) var(--primary-s) 60%);
--primary-500: hsl(var(--primary-h) var(--primary-s) var(--primary-l));
--primary-600: hsl(var(--primary-h) var(--primary-s) 45%);
--primary-700: hsl(var(--primary-h) var(--primary-s) 35%);
--primary-800: hsl(var(--primary-h) var(--primary-s) 25%);
--primary-900: hsl(var(--primary-h) var(--primary-s) 15%);
```

### Surface Colors

Surface colors are used for backgrounds, cards, and UI elements:

```css
--surface-h: 215;      /* Hue */
--surface-s: 15%;      /* Saturation */
--surface-l: 96%;      /* Lightness (light mode base) */
```

Surface shades are derived similarly:
- `surface-50` through `surface-400` for light mode
- Adjusted values for dark mode

### Text Colors

Text colors adapt to light/dark mode:

**Light Mode:**
```css
--text-primary: hsl(var(--surface-h) 20% 20%);  /* Dark text */
--text-muted:   hsl(var(--surface-h) 15% 40%); /* Muted text */
```

**Dark Mode:**
```css
--text-primary: hsl(var(--surface-h) 5% 92%);  /* Light text */
--text-muted:   hsl(var(--surface-h) 15% 60%); /* Muted text */
```

### Border and Ring Colors

```css
--border-color: hsl(var(--surface-h) 10% 80%);  /* Light mode */
--ring-color:   var(--primary-500);             /* Focus ring */
```

## Customizing Colors

### Changing the Primary Color

To change your brand color, edit `resources/css/app.css`:

```css
:root {
  /* Change to blue (240 degrees) */
  --primary-h: 240;
  --primary-s: 90%;
  --primary-l: 55%;
  
  /* Or change to green (120 degrees) */
  --primary-h: 120;
  --primary-s: 85%;
  --primary-l: 50%;
  
  /* Or change to red (0 degrees) */
  --primary-h: 0;
  --primary-s: 95%;
  --primary-l: 55%;
}
```

### Common Color Hues

| Color | Hue | Example |
|-------|-----|---------|
| Red | 0 | `--primary-h: 0;` |
| Orange | 30 | `--primary-h: 30;` |
| Yellow | 60 | `--primary-h: 60;` |
| Green | 120 | `--primary-h: 120;` |
| Cyan | 180 | `--primary-h: 180;` |
| Blue | 240 | `--primary-h: 240;` |
| Purple | 270 | `--primary-h: 270;` (default) |
| Pink | 330 | `--primary-h: 330;` |

### Adjusting Saturation and Lightness

**Saturation** controls color intensity:
- Higher (90-100%): Vibrant, bold colors
- Lower (50-70%): Muted, subtle colors

**Lightness** controls brightness:
- Higher (60-70%): Lighter, pastel colors
- Lower (40-50%): Darker, richer colors

Example for a softer blue:
```css
--primary-h: 240;
--primary-s: 70%;  /* Less saturated */
--primary-l: 60%;  /* Slightly lighter */
```

## HSL vs OKLCH

### HSL (Current Implementation)

VILT Canvas currently uses HSL (Hue, Saturation, Lightness) because:
- ✅ Wide browser support
- ✅ Easy to understand and adjust
- ✅ Simple to create color variations
- ✅ Works well with CSS custom properties

### OKLCH (Future Consideration)

OKLCH (OK Lightness, Chroma, Hue) is a newer color space that offers:
- ✅ Perceptually uniform lightness
- ✅ Better color consistency across devices
- ✅ More accurate color representation
- ⚠️ Limited browser support (growing)

**Example OKLCH syntax:**
```css
/* HSL */
--primary-500: hsl(270 90% 55%);

/* OKLCH (future) */
--primary-500: oklch(0.65 0.15 270);
```

The current HSL system can be easily migrated to OKLCH when browser support improves.

## Dark Mode Implementation

Dark mode is implemented using Tailwind's class-based approach:

```css
.dark {
  /* Surface colors get darker */
  --surface-l: 14%;
  --surface-50: hsl(var(--surface-h) var(--surface-s) 20%);
  --surface-100: hsl(var(--surface-h) var(--surface-s) 16%);
  /* ... */
  
  /* Text colors flip to light */
  --text-primary: hsl(var(--surface-h) 5% 92%);
  --text-muted: hsl(var(--surface-h) 15% 60%);
  
  /* Borders get darker */
  --border-color: hsl(var(--surface-h) 10% 30%);
}
```

The `LightDarkButton` component toggles the `dark` class on the `<html>` element, which activates all dark mode styles.

## Using Colors in Components

### Tailwind Classes

Colors are exposed as Tailwind utility classes:

```vue
<!-- Primary colors -->
<div class="bg-primary-500 text-white">Primary background</div>
<div class="text-primary-600">Primary text</div>
<div class="border-primary-400">Primary border</div>

<!-- Surface colors -->
<div class="bg-surface-100">Light surface</div>
<div class="bg-surface-200 dark:bg-surface-300">Adaptive surface</div>

<!-- Text colors -->
<p class="text-text-primary">Primary text</p>
<p class="text-text-muted">Muted text</p>

<!-- Border colors -->
<div class="border border-border">Bordered element</div>
```

### CSS Custom Properties

You can also use CSS variables directly:

```css
.custom-element {
  background-color: var(--primary-500);
  color: var(--text-primary);
  border-color: var(--border-color);
}
```

### In JavaScript/Vue

```vue
<script setup>
const primaryColor = 'var(--primary-500)';
</script>

<template>
  <div :style="{ backgroundColor: primaryColor }">
    Content
  </div>
</template>
```

## Color System Benefits

### 1. Consistency

All components use the same color system, ensuring visual consistency across the application.

### 2. Easy Theming

Change the entire theme by adjusting a few variables:

```css
/* Switch from purple to blue theme */
--primary-h: 240;  /* Changed from 270 */
```

### 3. Automatic Dark Mode

Dark mode works automatically - no need to define separate colors for each mode.

### 4. Accessible Contrast

The system ensures proper contrast ratios for text readability in both light and dark modes.

### 5. Maintainable

Centralized color definitions make it easy to update the entire application's color scheme.

## Examples

### Example 1: Blue Theme

```css
:root {
  --primary-h: 240;  /* Blue */
  --primary-s: 90%;
  --primary-l: 55%;
}
```

### Example 2: Green Theme

```css
:root {
  --primary-h: 120;  /* Green */
  --primary-s: 85%;
  --primary-l: 50%;
}
```

### Example 3: Muted Theme

```css
:root {
  --primary-h: 270;  /* Purple */
  --primary-s: 60%;  /* Lower saturation */
  --primary-l: 55%;
}
```

## Advanced Customization

### Custom Color Shades

To add custom shades, extend the system:

```css
:root {
  /* Add custom shade */
  --primary-550: hsl(var(--primary-h) var(--primary-s) 50%);
}
```

Then register it in the `@theme` block:

```css
@theme {
  --color-primary-550: var(--primary-550);
}
```

### Multiple Color Palettes

For multiple color palettes (e.g., success, error, warning), you can extend the system:

```css
:root {
  /* Success colors */
  --success-h: 120;
  --success-s: 90%;
  --success-l: 55%;
  --success-500: hsl(var(--success-h) var(--success-s) var(--success-l));
  
  /* Error colors */
  --error-h: 0;
  --error-s: 95%;
  --error-l: 55%;
  --error-500: hsl(var(--error-h) var(--error-s) var(--error-l));
}
```

## Troubleshooting

### Colors Not Updating

1. Clear browser cache
2. Rebuild assets: `npm run build`
3. Check for CSS specificity issues

### Dark Mode Not Working

1. Ensure `LightDarkButton` is included
2. Check that `dark` class is applied to `<html>` element
3. Verify dark mode styles are in `app.css`

### Color Inconsistencies

1. Ensure all components use Tailwind classes or CSS variables
2. Avoid hardcoded color values
3. Use the color system consistently

## Resources

- [HSL Color Picker](https://hslpicker.com/)
- [Tailwind CSS Custom Colors](https://tailwindcss.com/docs/customizing-colors)
- [OKLCH Color Space](https://oklch.com/)
- [CSS Custom Properties](https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_custom_properties)

