ALTER TABLE solicitud
ADD COLUMN id_profesional_acargo INTEGER;

ALTER TABLE solicitud
ADD CONSTRAINT solicitud_id_profesional_acargo_fkey
FOREIGN KEY (id_profesional_acargo) REFERENCES profesional(id_profesional);
