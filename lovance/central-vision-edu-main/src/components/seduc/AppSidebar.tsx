import { Link, useRouterState } from "@tanstack/react-router";
import {
  LayoutDashboard,
  Users,
  School,
  CalendarDays,
  Boxes,
  ShieldCheck,
  Component,
  GraduationCap,
  ChevronLeft,
  LogOut,
  Settings,
} from "lucide-react";
import { cn } from "@/lib/utils";

const nav = [
  { to: "/dashboard", label: "Dashboard", icon: LayoutDashboard, group: "Principal" },
  { to: "/modulos", label: "Módulos", icon: Boxes, group: "Administración" },
  { to: "/usuarios", label: "Usuarios", icon: Users, group: "Administración" },
  { to: "/colegios", label: "Colegios", icon: School, group: "Operación" },
  { to: "/eventos", label: "Eventos", icon: CalendarDays, group: "Operación" },
  { to: "/permisos", label: "Permisos", icon: ShieldCheck, group: "Seguridad" },
  { to: "/componentes", label: "Componentes UI", icon: Component, group: "Sistema" },
] as const;

export function AppSidebar({
  collapsed,
  onToggle,
}: {
  collapsed: boolean;
  onToggle: () => void;
}) {
  const pathname = useRouterState({ select: (s) => s.location.pathname });

  const groups = Array.from(new Set(nav.map((n) => n.group)));

  return (
    <aside
      className={cn(
        "fixed inset-y-0 left-0 z-30 flex flex-col bg-sidebar text-sidebar-foreground border-r border-sidebar-border transition-[width] duration-200",
        collapsed ? "w-[72px]" : "w-[260px]",
      )}
    >
      {/* Logo */}
      <div className="flex items-center gap-3 px-4 h-16 border-b border-sidebar-border">
        <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-seduc-blue text-seduc-blue-foreground">
          <GraduationCap className="h-5 w-5" />
        </div>
        {!collapsed && (
          <div className="flex flex-col leading-tight">
            <span className="text-sm font-semibold">SEDUC Chile</span>
            <span className="text-[11px] text-sidebar-foreground/60">Panel Central</span>
          </div>
        )}
      </div>

      {/* Nav */}
      <nav className="flex-1 overflow-y-auto py-4 px-2">
        {groups.map((g) => (
          <div key={g} className="mb-4">
            {!collapsed && (
              <div className="px-3 pb-2 text-[10px] font-semibold uppercase tracking-wider text-sidebar-foreground/40">
                {g}
              </div>
            )}
            <ul className="space-y-1">
              {nav
                .filter((n) => n.group === g)
                .map((n) => {
                  const Icon = n.icon;
                  const active = pathname === n.to;
                  return (
                    <li key={n.to}>
                      <Link
                        to={n.to}
                        className={cn(
                          "flex items-center gap-3 rounded-md px-3 py-2 text-sm transition-colors",
                          "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
                          active &&
                            "bg-sidebar-accent text-sidebar-accent-foreground border-l-2 border-seduc-yellow pl-[10px]",
                          collapsed && "justify-center px-0",
                        )}
                        title={collapsed ? n.label : undefined}
                      >
                        <Icon className="h-4 w-4 shrink-0" />
                        {!collapsed && <span className="truncate">{n.label}</span>}
                      </Link>
                    </li>
                  );
                })}
          </ul>
          </div>
        ))}
      </nav>

      {/* Footer */}
      <div className="border-t border-sidebar-border p-2 space-y-1">
        <button
          className={cn(
            "flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-sidebar-accent",
            collapsed && "justify-center px-0",
          )}
        >
          <Settings className="h-4 w-4" />
          {!collapsed && <span>Configuración</span>}
        </button>
        <Link
          to="/"
          className={cn(
            "flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-sidebar-accent",
            collapsed && "justify-center px-0",
          )}
        >
          <LogOut className="h-4 w-4" />
          {!collapsed && <span>Cerrar sesión</span>}
        </Link>
        <button
          onClick={onToggle}
          className={cn(
            "flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-sidebar-accent",
            collapsed && "justify-center px-0",
          )}
        >
          <ChevronLeft
            className={cn("h-4 w-4 transition-transform", collapsed && "rotate-180")}
          />
          {!collapsed && <span>Colapsar</span>}
        </button>
      </div>
    </aside>
  );
}
