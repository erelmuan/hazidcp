-- SEQUENCE: public.configusuariopac_id_seq

-- DROP SEQUENCE public.configusuariopac_id_seq;

CREATE SEQUENCE public.configusuariopac_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 2147483647
    CACHE 1;

ALTER SEQUENCE public.configusuariopac_id_seq
    OWNER TO postgres;

    -- Table: public.configusuariopac

    -- DROP TABLE public.configusuariopac;

    CREATE TABLE public.configusuariopac
    (
        id integer NOT NULL DEFAULT nextval('configusuariopac_id_seq'::regclass),
        id_usuario integer NOT NULL,
        pacinternados boolean,
        pacsininternacion boolean,
        pacalta boolean,
        CONSTRAINT configusuariopac_pkey PRIMARY KEY (id),
        CONSTRAINT configusuariopac_id_usuario_fkey FOREIGN KEY (id_usuario)
            REFERENCES public.usuario (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
    )

    TABLESPACE pg_default;

    ALTER TABLE public.configusuariopac
        OWNER to postgres;

    COMMENT ON TABLE public.configusuariopac
        IS 'Esta tabla guarda la configuracion de cada usuario respecto de la visualizacion de la internacion de cada paciente, los cuales pueden estar:
    internados
    sin internacion
    dados de alta';
