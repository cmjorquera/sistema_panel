import { createFileRoute } from "@tanstack/react-router";
import { Plus, ChevronLeft, ChevronRight, Pencil, Eye } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { StatusBadge } from "@/components/seduc/StatusBadge";
import { eventos } from "@/lib/seduc-data";
import { cn } from "@/lib/utils";

export const Route = createFileRoute("/_app/eventos")({
  head: () => ({ meta: [{ title: "Eventos — SEDUC Panel" }] }),
  component: EventosPage,
});

function EventosPage() {
  // Maqueta: mayo 2026, comienza un viernes (día 1 = vie)
  const days = Array.from({ length: 31 }, (_, i) => i + 1);
  const startOffset = 4; // viernes = índice 4 (lun=0)
  const eventDays = new Map<number, { titulo: string; estado: string }[]>();
  eventos.forEach((e) => {
    const d = parseInt(e.fecha.split("-")[0], 10);
    if (!eventDays.has(d)) eventDays.set(d, []);
    eventDays.get(d)!.push({ titulo: e.titulo, estado: e.estado });
  });

  const dayNames = ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"];

  return (
    <div className="space-y-6">
      <header className="flex items-start justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-semibold">Eventos y calendario</h1>
          <p className="text-sm text-muted-foreground">Agenda institucional SEDUC.</p>
        </div>
        <Button className="bg-seduc-blue hover:bg-seduc-blue/90">
          <Plus className="h-4 w-4 mr-2" /> Nuevo evento
        </Button>
      </header>

      <div className="grid gap-4 lg:grid-cols-3">
        <Card className="lg:col-span-2 shadow-card">
          <CardHeader className="flex-row items-center justify-between">
            <CardTitle className="text-base">Mayo 2026</CardTitle>
            <div className="inline-flex items-center gap-1">
              <Button variant="outline" size="icon" className="h-8 w-8">
                <ChevronLeft className="h-4 w-4" />
              </Button>
              <Button variant="outline" size="icon" className="h-8 w-8">
                <ChevronRight className="h-4 w-4" />
              </Button>
            </div>
          </CardHeader>
          <CardContent>
            <div className="grid grid-cols-7 gap-px bg-border rounded-lg overflow-hidden border border-border">
              {dayNames.map((d) => (
                <div
                  key={d}
                  className="bg-muted py-2 text-center text-[11px] font-semibold uppercase tracking-wide text-muted-foreground"
                >
                  {d}
                </div>
              ))}
              {Array.from({ length: startOffset }).map((_, i) => (
                <div key={`pad-${i}`} className="bg-card h-24" />
              ))}
              {days.map((d) => {
                const evs = eventDays.get(d);
                return (
                  <div
                    key={d}
                    className={cn(
                      "bg-card h-24 p-1.5 flex flex-col gap-1 hover:bg-muted/40 transition-colors",
                      d === 11 && "ring-2 ring-inset ring-seduc-blue",
                    )}
                  >
                    <span className="text-xs font-medium self-end text-muted-foreground">
                      {d}
                    </span>
                    {evs?.map((e, i) => (
                      <div
                        key={i}
                        className={cn(
                          "text-[10px] leading-tight truncate rounded px-1.5 py-0.5",
                          e.estado === "confirmado" && "bg-success/15 text-success",
                          e.estado === "pendiente" && "bg-warning/20 text-foreground",
                          e.estado === "realizado" && "bg-seduc-blue/15 text-seduc-blue",
                          e.estado === "cancelado" &&
                            "bg-destructive/10 text-destructive line-through",
                        )}
                      >
                        {e.titulo}
                      </div>
                    ))}
                  </div>
                );
              })}
            </div>
          </CardContent>
        </Card>

        <Card className="shadow-card">
          <CardHeader>
            <CardTitle className="text-base">Lista de eventos</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            {eventos.map((e) => (
              <div
                key={e.id}
                className="rounded-md border border-border p-3 hover:bg-muted/40 transition-colors"
              >
                <div className="flex items-start justify-between gap-2">
                  <div className="min-w-0">
                    <p className="text-sm font-medium truncate">{e.titulo}</p>
                    <p className="text-xs text-muted-foreground">
                      {e.fecha} · {e.hora} · {e.lugar}
                    </p>
                  </div>
                  <StatusBadge status={e.estado} />
                </div>
                <div className="mt-2 flex gap-1">
                  <Button variant="ghost" size="sm" className="h-7 px-2 text-xs">
                    <Eye className="h-3.5 w-3.5 mr-1" /> Revisar
                  </Button>
                  <Button variant="ghost" size="sm" className="h-7 px-2 text-xs">
                    <Pencil className="h-3.5 w-3.5 mr-1" /> Editar
                  </Button>
                </div>
              </div>
            ))}
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
