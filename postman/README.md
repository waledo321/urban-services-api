# Postman + GitHub workflow (for frontend & mobile)

## What lives in this repo

- `Urban-Services-API.postman_collection.json` — all HTTP requests and tests.
- `Urban-Services-Local.postman_environment.json` — `baseUrl`, `token`, and IDs used by the collection.

After `git pull`, re-import both files in Postman if you prefer file-based sync, or use a Postman team workspace (below).

## Local setup (every developer)

1. Install [Postman](https://www.postman.com/downloads/).
2. **Import** → choose `Urban-Services-API.postman_collection.json` and `Urban-Services-Local.postman_environment.json`.
3. Select environment **Urban Services API - Local**.
4. Set `baseUrl` (e.g. `http://127.0.0.1:8000` or your staging URL).
5. Run **Auth → Login**; the test script saves `token` for Bearer auth on other requests. You can include optional **`fcm_token`** in the login JSON so the backend stores the device token in the same request (Flutter can send it after Firebase Messaging returns the token).

## Postman “online” (team / cloud)

1. Create a free [Postman account](https://www.postman.com/).
2. Create a **Workspace** (e.g. “Urban Services”) and invite frontend/mobile with **Viewer** or **Editor** roles.
3. **Import** the same JSON files into that workspace, or use **File → Import** after each backend release.
4. Optional: enable **Public documentation** (paid tiers) or share read-only collection links from the workspace.

Keeping the JSON files in GitHub means the collection is versioned with the API; Postman Cloud is for sharing and commenting without everyone editing raw JSON.

## GitHub for the frontend team

- **Backend (this repo):** `git pull` here updates Laravel code, migrations, and the `postman/` folder together.
- **Flutter / SPA (separate repo):** `git pull` there updates UI only. Point `BASE_URL` at the same API version your Postman environment uses.
- **Release discipline:** tag releases (`v1.2.0`) and mention breaking API changes in GitHub **Releases** or `CHANGELOG.md` so mobile knows when to retest Postman flows.

## Do not commit secrets

Tokens and Firebase keys stay in Postman **Current value** (local) or CI secrets — not in committed environment files if they contain real credentials.
