-- Type: enumerativo_actividad

-- DROP TYPE public.enumerativo_actividad;

CREATE TYPE public.enumerativo_actividad AS ENUM
    ('ASISTENCIAL INDIVIDUAL Y/Ó GRUPAL', 'NO ASISTENCIAL');

ALTER TYPE public.enumerativo_actividad
    OWNER TO postgres;


-- SEQUENCE: public.tipoactividad_id_seq

-- DROP SEQUENCE public.tipoactividad_id_seq;
CREATE SEQUENCE public.tipoactividad_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.tipoactividad_id_seq
    OWNER TO postgres;


CREATE TABLE public.tipoactividad
(
    id integer NOT NULL DEFAULT nextval('tipoactividad_id_seq'::regclass),
    clasificacion enumerativo_actividad NOT NULL,
    descripcion character varying COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT tipoactividad_pkey PRIMARY KEY (id)
)

-- SEQUENCE: public.actividad_id_seq

-- DROP SEQUENCE public.actividad_id_seq;

CREATE SEQUENCE public.actividad_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.actividad_id_seq
    OWNER TO postgres;



    -- Table: public.actividad

    -- DROP TABLE public.actividad;

    CREATE TABLE public.actividad
    (
        id integer NOT NULL DEFAULT nextval('actividad_id_seq'::regclass),
        id_tipoactividad integer NOT NULL,
        clasificacion enumerativo_actividad NOT NULL,
        paciente character varying COLLATE pg_catalog."default",
        observacion text COLLATE pg_catalog."default",
        fechahora timestamp without time zone NOT NULL,
        id_usuario integer NOT NULL,
        CONSTRAINT actividad_pkey PRIMARY KEY (id),
        CONSTRAINT actividad_id_tipoactividad_fkey FOREIGN KEY (id_tipoactividad)
            REFERENCES public.tipoactividad (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION,
        CONSTRAINT actividad_id_usuario_fkey FOREIGN KEY (id_usuario)
            REFERENCES public.usuario (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
            NOT VALID
    )

    TABLESPACE pg_default;

    ALTER TABLE public.actividad
        OWNER to postgres;

        DELETE FROM public.tipoconsulta
        DELETE FROM public.atencion
