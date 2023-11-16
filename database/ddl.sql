-- public.failed_jobs definition

-- Drop table

-- DROP TABLE public.failed_jobs;

CREATE TABLE public.failed_jobs (
	id bigserial NOT NULL,
	"uuid" varchar(255) NOT NULL,
	"connection" text NOT NULL,
	queue text NOT NULL,
	payload text NOT NULL,
	"exception" text NOT NULL,
	failed_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT failed_jobs_pkey PRIMARY KEY (id),
	CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid)
);


-- public.migrations definition

-- Drop table

-- DROP TABLE public.migrations;

CREATE TABLE public.migrations (
	id serial4 NOT NULL,
	migration varchar(255) NOT NULL,
	batch int4 NOT NULL,
	CONSTRAINT migrations_pkey PRIMARY KEY (id)
);


-- public.password_reset_tokens definition

-- Drop table

-- DROP TABLE public.password_reset_tokens;

CREATE TABLE public.password_reset_tokens (
	email varchar(255) NOT NULL,
	"token" varchar(255) NOT NULL,
	created_at timestamp(0) NULL,
	CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email)
);


-- public.personal_access_tokens definition

-- Drop table

-- DROP TABLE public.personal_access_tokens;

CREATE TABLE public.personal_access_tokens (
	id bigserial NOT NULL,
	tokenable_type varchar(255) NOT NULL,
	tokenable_id int8 NOT NULL,
	"name" varchar(255) NOT NULL,
	"token" varchar(64) NOT NULL,
	abilities text NULL,
	last_used_at timestamp(0) NULL,
	expires_at timestamp(0) NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id),
	CONSTRAINT personal_access_tokens_token_unique UNIQUE (token)
);
CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


-- public.persons definition

-- Drop table

-- DROP TABLE public.persons;

CREATE TABLE public.persons (
	id bigserial NOT NULL,
	first_name varchar(255) NOT NULL,
	last_name varchar(255) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT persons_pkey PRIMARY KEY (id)
);


-- public.users definition

-- Drop table

-- DROP TABLE public.users;

CREATE TABLE public.users (
	id bigserial NOT NULL,
	"name" varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	email_verified_at timestamp(0) NULL,
	"password" varchar(255) NOT NULL,
	remember_token varchar(100) NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT users_email_unique UNIQUE (email),
	CONSTRAINT users_pkey PRIMARY KEY (id)
);


-- public.addresses definition

-- Drop table

-- DROP TABLE public.addresses;

CREATE TABLE public.addresses (
	id bigserial NOT NULL,
	person_id int8 NOT NULL,
	address_type varchar(255) NOT NULL,
	country varchar(100) NOT NULL,
	city varchar(100) NOT NULL,
	street varchar(150) NOT NULL,
	"number" varchar(10) NOT NULL,
	zip varchar(10) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT addresses_address_type_check CHECK (((address_type)::text = ANY ((ARRAY['home'::character varying, 'work'::character varying])::text[]))),
	CONSTRAINT addresses_pkey PRIMARY KEY (id),
	CONSTRAINT addresses_person_id_foreign FOREIGN KEY (person_id) REFERENCES public.persons(id) ON DELETE CASCADE
);


-- public.contacts definition

-- Drop table

-- DROP TABLE public.contacts;

CREATE TABLE public.contacts (
	id bigserial NOT NULL,
	person_id int8 NOT NULL,
	contact_type varchar NOT NULL,
	contact_info varchar(255) NOT NULL,
	created_at timestamp(0) NULL,
	updated_at timestamp(0) NULL,
	CONSTRAINT contacts_pkey PRIMARY KEY (id),
	CONSTRAINT contacts_person_id_foreign FOREIGN KEY (person_id) REFERENCES public.persons(id) ON DELETE CASCADE
);
CREATE INDEX contacts_person_id_contact_type_id_index ON public.contacts USING btree (person_id, contact_type);