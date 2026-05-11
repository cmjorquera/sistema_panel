import { createFileRoute, Link } from "@tanstack/react-router";
import {
  Users,
  School,
  CalendarDays,
  TicketCheck,
  Boxes,
  ArrowUpRight,
  Plus,
  FileText,
  ShieldCheck,
} from "lucide-react";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  ResponsiveContainer,
  AreaChart,
  Area,
  XAxis,
  YAxis,
  Tooltip,
  CartesianGrid,
  BarChart,
  Bar,
} from "recharts";
import { stats, actividad, eventos, chartData } from "@/lib/seduc-data";
import { StatusBadge } from "@/components/seduc/StatusBadge";
import { cn } from "@/lib/utils";

export const Route = createFileRoute("/_app/dashboard")({
  head: () => ({
    meta: [{ title: "Dashboard — SEDUC Panel Central" }],
  }),
  component: Dashboard,
});

const iconMap = { users: Users, school: School, calendar: CalendarDays, ticket: TicketCheck };
const colorMap = {
  blue: "bg-seduc-blue/10 text-seduc-blue",
  green: "bg-seduc-green/10 text-seduc-green",
  yellow: "bg-seduc-yellow/15 text-seduc-yellow-foreground",
  graphite: "bg-seduc-graphite/10 text-seduc-graphite",
};

function Dashboard() {
  return (
    <div className="space-y-6">
      <div className="flex items-start justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-semibold text-foreground">Resumen general</h1>
          <p className="text-sm text-muted-foreground">
            Vista consolidada del Sistema Panel Central — SEDUC Chile.
          </p>
        </div>
        <div className="flex gap-2">
          <Button variant="outline">
            <FileText className="h-4 w-4 mr-2" /> Exportar reporte
          </Button>
          <Button className="bg-seduc-blue hover:bg-seduc-blue/90">
            <Plus className="h-4 w-4 mr-2" /> Nuevo registro
          </Button>
        </div>
      </div>

      {/* Stats */}
      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {stats.map((s) => {
          const Icon = iconMap[s.icon as keyof typeof iconMap];
          const positive = s.delta.startsWith("+");
          return (
            <Card key={s.label} className="shadow-card">
              <CardContent className="p-5">
                <div className="flex items-start justify-between">
                  <div>
                    <p className="text-sm text-muted-foreground">{s.label}</p>
                    <p className="mt-2 text-3xl font-semibold tracking-tight">{s.value}</p>
                    <p
                      className={cn(
                        "mt-2 text-xs font-medium",
                        positive ? "text-success" : "text-destructive",
                      )}
                    >
                      {s.delta} vs mes anterior
                    </p>
                  </div>
                  <div
                    className={cn(
                      "flex h-10 w-10 items-center justify-center rounded-md",
                      colorMap[s.color],
                    )}
                  >
                    <Icon className="h-5 w-5" />
                  </div>
                </div>
              </CardContent>
            </Card>
          );
        })}
      </div>

      {/* Charts */}
      <div className="grid gap-4 lg:grid-cols-3">
        <Card className="lg:col-span-2 shadow-card">
          <CardHeader className="flex-row items-center justify-between">
            <div>
              <CardTitle className="text-base">Crecimiento de usuarios</CardTitle>
              <CardDescription>Últimos 6 meses</CardDescription>
            </div>
            <span className="text-xs text-muted-foreground">Datos demostrativos</span>
          </CardHeader>
          <CardContent className="h-72">
            <ResponsiveContainer width="100%" height="100%">
              <AreaChart data={chartData}>
                <defs>
                  <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stopColor="var(--color-seduc-blue)" stopOpacity={0.35} />
                    <stop offset="100%" stopColor="var(--color-seduc-blue)" stopOpacity={0} />
                  </linearGradient>
                </defs>
                <CartesianGrid strokeDasharray="3 3" stroke="var(--color-border)" />
                <XAxis dataKey="mes" stroke="var(--color-muted-foreground)" fontSize={12} />
                <YAxis stroke="var(--color-muted-foreground)" fontSize={12} />
                <Tooltip
                  contentStyle={{
                    background: "var(--color-card)",
                    border: "1px solid var(--color-border)",
                    borderRadius: 8,
                    fontSize: 12,
                  }}
                />
                <Area
                  type="monotone"
                  dataKey="usuarios"
                  stroke="var(--color-seduc-blue)"
                  strokeWidth={2}
                  fill="url(#g1)"
                />
              </AreaChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        <Card className="shadow-card">
          <CardHeader>
            <CardTitle className="text-base">Eventos por mes</CardTitle>
            <CardDescription>Calendario institucional</CardDescription>
          </CardHeader>
          <CardContent className="h-72">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart data={chartData}>
                <CartesianGrid strokeDasharray="3 3" stroke="var(--color-border)" />
                <XAxis dataKey="mes" stroke="var(--color-muted-foreground)" fontSize={12} />
                <YAxis stroke="var(--color-muted-foreground)" fontSize={12} />
                <Tooltip
                  contentStyle={{
                    background: "var(--color-card)",
                    border: "1px solid var(--color-border)",
                    borderRadius: 8,
                    fontSize: 12,
                  }}
                />
                <Bar dataKey="eventos" fill="var(--color-seduc-green)" radius={[4, 4, 0, 0]} />
              </BarChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>
      </div>

      {/* Quick access */}
      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {[
          { to: "/usuarios", label: "Gestionar usuarios", icon: Users, color: "seduc-blue" },
          { to: "/colegios", label: "Ver colegios", icon: School, color: "seduc-green" },
          { to: "/eventos", label: "Crear evento", icon: CalendarDays, color: "seduc-yellow" },
          { to: "/permisos", label: "Permisos", icon: ShieldCheck, color: "seduc-graphite" },
        ].map((q) => {
          const Icon = q.icon;
          return (
            <Link
              key={q.to}
              to={q.to}
              className="group rounded-lg border border-border bg-card p-4 hover:border-seduc-blue hover:shadow-elevated transition-all"
            >
              <div className="flex items-center justify-between">
                <Icon className={`h-5 w-5 text-${q.color}`} />
                <ArrowUpRight className="h-4 w-4 text-muted-foreground group-hover:text-seduc-blue transition-colors" />
              </div>
              <p className="mt-3 text-sm font-medium">{q.label}</p>
              <p className="text-xs text-muted-foreground">Acceso rápido</p>
            </Link>
          );
        })}
      </div>

      {/* Activity + Events */}
      <div className="grid gap-4 lg:grid-cols-3">
        <Card className="lg:col-span-2 shadow-card">
          <CardHeader>
            <CardTitle className="text-base">Actividad reciente</CardTitle>
            <CardDescription>Últimas acciones del sistema</CardDescription>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Usuario</TableHead>
                  <TableHead>Acción</TableHead>
                  <TableHead className="text-right">Cuándo</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {actividad.map((a, i) => (
                  <TableRow key={i}>
                    <TableCell className="font-medium">{a.user}</TableCell>
                    <TableCell className="text-muted-foreground">
                      {a.action} <span className="text-foreground">{a.target}</span>
                    </TableCell>
                    <TableCell className="text-right text-xs text-muted-foreground">
                      {a.time}
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </CardContent>
        </Card>

        <Card className="shadow-card">
          <CardHeader>
            <CardTitle className="text-base">Próximos eventos</CardTitle>
            <CardDescription>Avisos institucionales</CardDescription>
          </CardHeader>
          <CardContent className="space-y-3">
            {eventos.slice(0, 4).map((e) => (
              <div
                key={e.id}
                className="flex gap-3 rounded-md border border-border p-3 hover:bg-muted/40 transition-colors"
              >
                <div className="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-md bg-seduc-blue/10 text-seduc-blue">
                  <span className="text-[10px] font-medium uppercase">
                    {e.fecha.split("-")[1]}
                  </span>
                  <span className="text-base font-semibold leading-none">
                    {e.fecha.split("-")[0]}
                  </span>
                </div>
                <div className="min-w-0 flex-1">
                  <p className="text-sm font-medium truncate">{e.titulo}</p>
                  <p className="text-xs text-muted-foreground">
                    {e.hora} · {e.lugar}
                  </p>
                  <div className="mt-1.5">
                    <StatusBadge status={e.estado} />
                  </div>
                </div>
              </div>
            ))}
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
