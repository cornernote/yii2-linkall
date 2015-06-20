/**
 * SQLite
 */

DROP TABLE IF EXISTS "post";

CREATE TABLE "post" (
  "id" INTEGER NOT NULL PRIMARY KEY,
  "title" TEXT NOT NULL,
  "body" TEXT NOT NULL
);

DROP TABLE IF EXISTS "tag";

CREATE TABLE "tag" (
  "id" INTEGER NOT NULL PRIMARY KEY,
  "name" TEXT NOT NULL
);

DROP TABLE IF EXISTS "post_to_tag";

CREATE TABLE "post_to_tag" (
  "post_id"  INTEGER NOT NULL,
  "tag_id"  INTEGER NOT NULL,
  PRIMARY KEY ("post_id", "tag_id")
);