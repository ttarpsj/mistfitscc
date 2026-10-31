# MISTFITS merchandise catalog

The `/shop` page reads every `.json` file in this folder when Laravel renders the page and when the static Pages export runs. Add, remove, or edit an item here—no database or Blade changes are needed.

Each item supports:

```json
{
  "name": "MISTFITS / RACE JERSEY",
  "type": "SHORT SLEEVE JERSEY",
  "tone": "ink",
  "order": 1
}
```

`tone` can be `ink`, `paper`, `grid`, or `line`. `order` controls the card position.
