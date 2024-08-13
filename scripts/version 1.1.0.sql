-- se procede a eliminar la relacion de respuesta con atencion
ALTER TABLE atencion
DROP COLUMN id_respuesta;

--Agrego columna respuesta a la tabla atencion
ALTER TABLE atencion
ADD COLUMN respuesta CHARACTER VARYING;

--luego se elimina la tabla
DELETE FROM respuesta

--Creo la tabla detalle
-- Table: public.detalle

-- DROP TABLE public.detalle;

-- SEQUENCE: public.detalle_id_seq

-- DROP SEQUENCE public.detalle_id_seq;

CREATE SEQUENCE public.detalle_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.detalle_id_seq
    OWNER TO postgres;

CREATE TABLE public.detalle
(
    id integer NOT NULL DEFAULT nextval('detalle_id_seq'::regclass),
    descripcion character varying COLLATE pg_catalog."default" NOT NULL,
    id_tipoegreso integer NOT NULL,
    CONSTRAINT detalle_pkey PRIMARY KEY (id),
    CONSTRAINT detalle_descripcion_id_tipoegreso_key UNIQUE (descripcion, id_tipoegreso),
    CONSTRAINT detalle_id_tipoegreso_fkey FOREIGN KEY (id_tipoegreso)
        REFERENCES public.tipoegreso (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE public.detalle
    OWNER to postgres;

--Agrego el campo id_detalle en la tabla internacion
ALTER TABLE internacion
ADD COLUMN id_detalle INTEGER;

ALTER TABLE internacion
ADD CONSTRAINT internacion_id_detalle_fkey
FOREIGN KEY (id_detalle) REFERENCES detalle(id);
