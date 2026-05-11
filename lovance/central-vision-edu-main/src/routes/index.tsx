import { createFileRoute, Link } from "@tanstack/react-router";
import { GraduationCap } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Checkbox } from "@/components/ui/checkbox";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "Acceso — SEDUC Chile · Panel Central" },
      { name: "description", content: "Acceso institucional al Sistema Panel Central SEDUC Chile." },
    ],
  }),
  component: LoginPage,
});

function LoginPage() {
  return (
    <div className="min-h-screen grid lg:grid-cols-2">
      {/* Brand panel */}
      <div className="relative hidden lg:flex flex-col justify-between p-12 text-white overflow-hidden bg-seduc-graphite">
        <div
          className="absolute inset-0 opacity-90"
          style={{
            background:
              "linear-gradient(135deg, oklch(0.31 0.012 270) 0%, oklch(0.36 0.05 250) 50%, oklch(0.30 0.10 245) 100%)",
          }}
        />
        <div
          className="absolute inset-0 opacity-[0.06]"
          style={{
            backgroundImage:
              "radial-gradient(circle at 1px 1px, white 1px, transparent 0)",
            backgroundSize: "24px 24px",
          }}
        />
        <div className="relative z-10 flex items-center gap-3">
          <div className="flex h-11 w-11 items-center justify-center rounded-md bg-white/10 backdrop-blur">
            <GraduationCap className="h-6 w-6" />
          </div>
          <div className="leading-tight">
            <div className="text-base font-semibold">SEDUC Chile</div>
            <div className="text-xs text-white/60">Servicio de Educación</div>
          </div>
        </div>

        <div className="relative z-10 max-w-md">
          <div className="h-1 w-12 bg-seduc-yellow mb-6 rounded-full" />
          <h1 className="text-4xl font-semibold leading-tight">
            Sistema Panel Central
          </h1>
          <p className="mt-4 text-white/70 text-base">
            Plataforma institucional para la gestión administrativa, académica
            y operacional de los establecimientos educacionales bajo
            dependencia SEDUC.
          </p>
          <p className="mt-10 italic text-seduc-yellow text-lg font-medium">
            “Educar para servir.”
          </p>
        </div>

        <div className="relative z-10 text-xs text-white/50">
          © {new Date().getFullYear()} Servicio Local de Educación Pública
        </div>
      </div>

      {/* Form */}
      <div className="flex items-center justify-center p-6 sm:p-12 bg-background">
        <div className="w-full max-w-md">
          <div className="lg:hidden flex items-center gap-3 mb-8">
            <div className="flex h-10 w-10 items-center justify-center rounded-md bg-seduc-blue text-seduc-blue-foreground">
              <GraduationCap className="h-5 w-5" />
            </div>
            <div className="leading-tight">
              <div className="text-sm font-semibold">SEDUC Chile</div>
              <div className="text-xs text-muted-foreground">Panel Central</div>
            </div>
          </div>

          <div className="rounded-xl border border-border bg-card p-8 shadow-card">
            <h2 className="text-2xl font-semibold text-foreground">Iniciar sesión</h2>
            <p className="mt-1 text-sm text-muted-foreground">
              Acceso restringido a personal autorizado.
            </p>

            <form
              className="mt-8 space-y-5"
              onSubmit={(e) => {
                e.preventDefault();
                window.location.href = "/dashboard";
              }}
            >
              <div className="space-y-2">
                <Label htmlFor="user">Usuario o correo institucional</Label>
                <Input
                  id="user"
                  placeholder="usuario@seduc.cl"
                  defaultValue="msoto@seduc.cl"
                />
              </div>
              <div className="space-y-2">
                <div className="flex items-center justify-between">
                  <Label htmlFor="pwd">Contraseña</Label>
                  <a className="text-xs text-seduc-blue hover:underline" href="#">
                    ¿Olvidaste tu clave?
                  </a>
                </div>
                <Input id="pwd" type="password" placeholder="••••••••" defaultValue="demo1234" />
              </div>
              <label className="flex items-center gap-2 text-sm text-muted-foreground">
                <Checkbox defaultChecked /> Mantener sesión iniciada
              </label>

              <Button
                type="submit"
                className="w-full h-11 bg-seduc-blue hover:bg-seduc-blue/90 text-seduc-blue-foreground font-medium"
              >
                Ingresar al panel
              </Button>

              <div className="pt-2 text-center">
                <Link to="/dashboard" className="text-xs text-muted-foreground hover:text-foreground">
                  Acceder en modo demostración →
                </Link>
              </div>
            </form>
          </div>

          <p className="mt-6 text-center text-xs text-muted-foreground">
            Al continuar aceptas los términos de uso y la política de privacidad institucional.
          </p>
        </div>
      </div>
    </div>
  );
}
