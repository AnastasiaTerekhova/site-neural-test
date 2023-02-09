import { AppModule } from './app.module';
import { NestFactory } from '@nestjs/core';

async function bootstrap() {
    const PORT = process.env.PORT || 5000;
    const app = await NestFactory.create(AppModule);
    app.enableCors();

    await app.listen(PORT, () => {
        console.log(`Server started on port = ${PORT}`);
    });
}
bootstrap();
