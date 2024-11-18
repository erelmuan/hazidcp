-- Cambiar el nombre de la columna 'paciente' a 'pacienteint' (asegurando que el tipo sea entero)
ALTER TABLE public.actividad
    RENAME COLUMN paciente TO pacienteint;

-- Agregar la columna 'id_paciente'
ALTER TABLE public.actividad
    ADD COLUMN id_paciente INTEGER;

-- Establecer 'id_paciente' como clave foránea que referencia a la tabla 'paciente'
ALTER TABLE public.actividad
    ADD CONSTRAINT actividad_id_paciente_fkey FOREIGN KEY (id_paciente)
        REFERENCES public.paciente (id)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION;
