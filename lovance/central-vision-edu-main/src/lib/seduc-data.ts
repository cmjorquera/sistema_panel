// Datos ficticios para la maqueta SEDUC. NO usar en producción.

export const stats = [
  { label: "Usuarios activos", value: "1.284", delta: "+4,2%", color: "blue" as const, icon: "users" },
  { label: "Colegios registrados", value: "312", delta: "+1,8%", color: "green" as const, icon: "school" },
  { label: "Eventos del mes", value: "47", delta: "+12", color: "yellow" as const, icon: "calendar" },
  { label: "Tickets abiertos", value: "8", delta: "-3", color: "graphite" as const, icon: "ticket" },
];

export const modulos = [
  { id: 1, nombre: "Gestión Académica", slug: "academico", estado: "activo", actualizado: "12-05-2026" },
  { id: 2, nombre: "Recursos Humanos", slug: "rrhh", estado: "activo", actualizado: "10-05-2026" },
  { id: 3, nombre: "Finanzas y Presupuesto", slug: "finanzas", estado: "activo", actualizado: "08-05-2026" },
  { id: 4, nombre: "Convivencia Escolar", slug: "convivencia", estado: "inactivo", actualizado: "01-04-2026" },
  { id: 5, nombre: "Bienestar Estudiantil", slug: "bienestar", estado: "activo", actualizado: "05-05-2026" },
  { id: 6, nombre: "Reportes Ministeriales", slug: "reportes-mineduc", estado: "activo", actualizado: "11-05-2026" },
];

export const usuarios = [
  { id: 1, nombre: "María Fernanda Soto", rut: "12.345.678-9", correo: "msoto@seduc.cl", tipo: "Administrador", colegio: "DEPROV Central", estado: "activo" },
  { id: 2, nombre: "Carlos Pérez Muñoz", rut: "10.987.654-3", correo: "cperez@seduc.cl", tipo: "Coordinador", colegio: "Liceo Bicentenario", estado: "activo" },
  { id: 3, nombre: "Javiera Riquelme", rut: "15.432.187-K", correo: "jriquelme@seduc.cl", tipo: "Docente", colegio: "Escuela San Andrés", estado: "bloqueado" },
  { id: 4, nombre: "Pedro Vargas Cea", rut: "9.876.543-2", correo: "pvargas@seduc.cl", tipo: "Inspector", colegio: "Liceo Industrial", estado: "activo" },
  { id: 5, nombre: "Ana Bustamante", rut: "13.222.111-0", correo: "abustamante@seduc.cl", tipo: "Soporte TI", colegio: "DEPROV Norte", estado: "activo" },
];

export const colegios = [
  { id: 1, nombre: "Liceo Bicentenario Santiago", rbd: "10245-1", comuna: "Santiago", usuarios: 84, modulos: 6, eventos: 12, estado: "activo" },
  { id: 2, nombre: "Escuela San Andrés", rbd: "20188-3", comuna: "Maipú", usuarios: 42, modulos: 4, eventos: 5, estado: "activo" },
  { id: 3, nombre: "Liceo Industrial de Concepción", rbd: "31204-0", comuna: "Concepción", usuarios: 128, modulos: 6, eventos: 9, estado: "activo" },
  { id: 4, nombre: "Escuela Rural Los Aromos", rbd: "40887-2", comuna: "Curacaví", usuarios: 18, modulos: 3, eventos: 2, estado: "inactivo" },
  { id: 5, nombre: "Colegio Polivalente Valparaíso", rbd: "50921-7", comuna: "Valparaíso", usuarios: 96, modulos: 5, eventos: 7, estado: "activo" },
  { id: 6, nombre: "Liceo Técnico La Serena", rbd: "60554-4", comuna: "La Serena", usuarios: 71, modulos: 5, eventos: 4, estado: "activo" },
];

export const eventos = [
  { id: 1, titulo: "Consejo de Directores Regionales", fecha: "15-05-2026", hora: "10:00", lugar: "DEPROV Central", estado: "confirmado" },
  { id: 2, titulo: "Capacitación Plataforma SIGE", fecha: "18-05-2026", hora: "15:30", lugar: "Sala B-2", estado: "pendiente" },
  { id: 3, titulo: "Cierre de período académico", fecha: "22-05-2026", hora: "09:00", lugar: "Online", estado: "pendiente" },
  { id: 4, titulo: "Auditoría interna de finanzas", fecha: "08-05-2026", hora: "11:00", lugar: "Oficina central", estado: "realizado" },
  { id: 5, titulo: "Visita inspectiva Liceo Industrial", fecha: "02-05-2026", hora: "08:30", lugar: "Concepción", estado: "cancelado" },
];

export const actividad = [
  { user: "M. Soto", action: "creó el módulo", target: "Bienestar Estudiantil", time: "hace 5 min" },
  { user: "C. Pérez", action: "actualizó el colegio", target: "Liceo Bicentenario", time: "hace 22 min" },
  { user: "Sistema", action: "respaldo automático completado", target: "qaseduc_panel", time: "hace 1 h" },
  { user: "P. Vargas", action: "asignó permisos a", target: "J. Riquelme", time: "hace 2 h" },
  { user: "A. Bustamante", action: "cerró el ticket", target: "#1284 — Acceso SIGE", time: "hace 3 h" },
];

export const chartData = [
  { mes: "Dic", usuarios: 980, eventos: 28 },
  { mes: "Ene", usuarios: 1040, eventos: 32 },
  { mes: "Feb", usuarios: 1080, eventos: 30 },
  { mes: "Mar", usuarios: 1150, eventos: 41 },
  { mes: "Abr", usuarios: 1220, eventos: 39 },
  { mes: "May", usuarios: 1284, eventos: 47 },
];

export const permisosMenus = [
  {
    grupo: "Administración",
    items: [
      { nombre: "Dashboard", ver: true, crear: false, editar: false, eliminar: false },
      { nombre: "Usuarios", ver: true, crear: true, editar: true, eliminar: false },
      { nombre: "Permisos", ver: true, crear: true, editar: true, eliminar: true },
    ],
  },
  {
    grupo: "Operación",
    items: [
      { nombre: "Colegios", ver: true, crear: true, editar: true, eliminar: false },
      { nombre: "Módulos", ver: true, crear: false, editar: true, eliminar: false },
      { nombre: "Eventos", ver: true, crear: true, editar: true, eliminar: true },
    ],
  },
  {
    grupo: "Reportes",
    items: [
      { nombre: "Reportes ministeriales", ver: true, crear: false, editar: false, eliminar: false },
      { nombre: "Auditoría", ver: false, crear: false, editar: false, eliminar: false },
    ],
  },
];
