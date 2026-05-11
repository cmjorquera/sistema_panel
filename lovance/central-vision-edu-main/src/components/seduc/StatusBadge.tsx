import { cn } from "@/lib/utils";

type Variant = "activo" | "inactivo" | "bloqueado" | "pendiente" | "confirmado" | "realizado" | "cancelado";

const map: Record<Variant, string> = {
  activo: "bg-success/10 text-success border-success/20",
  confirmado: "bg-success/10 text-success border-success/20",
  realizado: "bg-seduc-blue/10 text-seduc-blue border-seduc-blue/20",
  pendiente: "bg-warning/15 text-warning-foreground border-warning/30",
  inactivo: "bg-muted text-muted-foreground border-border",
  bloqueado: "bg-destructive/10 text-destructive border-destructive/20",
  cancelado: "bg-destructive/10 text-destructive border-destructive/20",
};

export function StatusBadge({ status }: { status: string }) {
  const cls = map[(status as Variant)] ?? "bg-muted text-muted-foreground border-border";
  return (
    <span
      className={cn(
        "inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-medium capitalize",
        cls,
      )}
    >
      <span className="h-1.5 w-1.5 rounded-full bg-current" />
      {status}
    </span>
  );
}
